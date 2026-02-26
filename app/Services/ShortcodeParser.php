<?php

namespace App\Services;

use App\Models\LotteryResult;
use App\Models\Shortcode;

class ShortcodeParser
{
    private array $builtins = [
        'kqxs' => 'renderKqxs',
        'soi_cau' => 'renderSoiCau',
        'thong_ke' => 'renderThongKe',
        'lo_gan' => 'renderLoGan',
    ];

    public function parse(string $content): string
    {
        $pattern = '/\[([a-z_][a-z0-9_]*)((?:\s+[a-z_]+="[^"]*")*)\]/i';

        return preg_replace_callback($pattern, function ($matches) {
            $tag = strtolower($matches[1]);
            $attrs = $this->parseAttributes($matches[2] ?? '');

            if (isset($this->builtins[$tag])) {
                $method = $this->builtins[$tag];
                return $this->$method($attrs);
            }

            $custom = Shortcode::where('code', $tag)->where('is_active', true)->first();
            if ($custom) {
                return $this->renderCustom($custom, $attrs);
            }

            return $matches[0];
        }, $content);
    }

    private function parseAttributes(string $attrString): array
    {
        $attrs = [];
        preg_match_all('/([a-z_]+)="([^"]*)"/i', $attrString, $m, PREG_SET_ORDER);
        foreach ($m as $match) {
            $attrs[$match[1]] = $match[2];
        }
        return $attrs;
    }

    private function renderKqxs(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $result = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->first();

        if (!$result) {
            return '<p class="text-gray-400 italic">Chưa có dữ liệu KQXS.</p>';
        }

        return view('components.shortcodes.kqxs', compact('result', 'region'))->render();
    }

    private function renderSoiCau(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $service = new PredictionService();
        $prediction = $service->predict(null, $region);

        if (empty($prediction['top10'])) {
            return '<p class="text-gray-400 italic">Chưa có dữ liệu soi cầu.</p>';
        }

        return view('components.shortcodes.soi-cau', compact('prediction'))->render();
    }

    private function renderThongKe(array $attrs): string
    {
        $days = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')
            ->get();

        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);

        $frequency = array_slice($freq, 0, 20, true);

        return view('components.shortcodes.thong-ke', compact('frequency', 'days'))->render();
    }

    private function renderLoGan(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $limit = (int) ($attrs['limit'] ?? 10);

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(60)
            ->get();

        $lastSeen = [];
        foreach ($results as $idx => $r) {
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $idx;
                }
            }
        }
        arsort($lastSeen);

        $loGan = array_slice($lastSeen, 0, $limit, true);

        return view('components.shortcodes.lo-gan', compact('loGan'))->render();
    }

    private function renderCustom(Shortcode $shortcode, array $attrs): string
    {
        $html = $shortcode->content;
        foreach ($attrs as $key => $value) {
            $html = str_replace('{{' . $key . '}}', e($value), $html);
        }
        return $html;
    }
}
