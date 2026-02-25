<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LotteryController extends Controller
{
    private $apiUrl;
    
    public function __construct() {
        $this->apiUrl = 'http://xs-api:4002';
    }

    public function index()
    {
        try {
            // Lấy KQXS Miền Bắc mới nhất
            $responseMB = Http::get("{$this->apiUrl}/lottery/latest", ['region' => 'north']);
            $dataMB = $responseMB->json('data') ?? null;

            // Lấy KQXS Miền Trung mới nhất
            $responseMT = Http::get("{$this->apiUrl}/lottery/latest", ['region' => 'central']);
            $dataMT = $responseMT->json('data') ?? [];

            // Lấy KQXS Miền Nam mới nhất
            $responseMN = Http::get("{$this->apiUrl}/lottery/latest", ['region' => 'south']);
            $dataMN = $responseMN->json('data') ?? [];

            // Lấy dự đoán AI
            $responseAI = Http::get("{$this->apiUrl}/prediction-ai", ['region' => 'north']);
            $dataAI = $responseAI->json('data') ?? null;

            return view('welcome', [
                'lotteryMB' => $dataMB,
                'lotteryMT' => $dataMT,
                'lotteryMN' => $dataMN,
                'predictionAI' => $dataAI
            ]);
        } catch (\Exception $e) {
            return view('welcome', [
                'lotteryMB' => null,
                'lotteryMT' => [],
                'lotteryMN' => [],
                'predictionAI' => null
            ]);
        }
    }

    public function history($region = 'north')
    {
        try {
            $response = Http::get("{$this->apiUrl}/lottery/history", [
                'region' => $region,
                'limit' => 20
            ]);
            $history = $response->json('data') ?? [];

            return view('history', [
                'history' => $history,
                'region' => $region
            ]);
        } catch (\Exception $e) {
            return view('history', ['history' => [], 'region' => $region]);
        }
    }

    public function prediction()
    {
        try {
            $responseAI = Http::get("{$this->apiUrl}/prediction-ai", ['region' => 'north']);
            $prediction = $responseAI->json('data') ?? null;

            return view('prediction', [
                'prediction' => $prediction
            ]);
        } catch (\Exception $e) {
            return view('prediction', ['prediction' => null]);
        }
    }

    public function quayThu()
    {
        return view('quay-thu');
    }

    public function statistics()
    {
        try {
            $responseFreq = Http::get("{$this->apiUrl}/statistics/frequency");
            $freqData = $responseFreq->json("data") ?? [];
            $frequency = array_slice($freqData, 0, 10);

            $responseWait = Http::get("{$this->apiUrl}/statistics/waiting");
            $waitData = $responseWait->json("data") ?? [];
            $waiting = array_slice($waitData, 0, 10);

            return view('statistics', [
                'frequency' => $frequency,
                'waiting' => $waiting
            ]);
        } catch (\Exception $e) {
            return view('statistics', ['frequency' => [], 'waiting' => []]);
        }
    }

    public function bridge(Request $request)
    {
        $region = $request->query('region', 'north');
        $minLength = $request->query('minLength', 3);
        try {
            $response = Http::get("{$this->apiUrl}/bridge", ['region' => $region, 'minLength' => $minLength]);
            return $response->json() ?? ['success' => false, 'data' => []];
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
