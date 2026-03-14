<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview: {{ $page->title }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="/css/light-theme.css?v={{ filemtime(public_path('css/light-theme.css')) }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false, container: false }
        }
    </script>
    <style>
        .preview-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: linear-gradient(135deg, #1e293b, #334155);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
            font-family: 'Roboto', sans-serif;
        }
        .preview-toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .preview-toolbar-badge {
            background: #f59e0b;
            color: #1e293b;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .preview-toolbar-title {
            font-size: 14px;
            font-weight: 600;
        }
        .preview-toolbar-meta {
            font-size: 11px;
            color: #94a3b8;
        }
        .preview-toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .preview-toolbar-btn {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }
        .preview-toolbar-btn.edit {
            background: #3b82f6;
            color: #fff;
        }
        .preview-toolbar-btn.edit:hover {
            background: #2563eb;
        }
        .preview-toolbar-btn.back {
            background: rgba(255,255,255,0.1);
            color: #cbd5e1;
        }
        .preview-toolbar-btn.back:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
        .preview-toolbar-btn.close-bar {
            background: none;
            color: #94a3b8;
            padding: 6px;
            font-size: 16px;
        }
        .preview-toolbar-btn.close-bar:hover {
            color: #fff;
        }
        .preview-device-btns {
            display: flex;
            gap: 4px;
            background: rgba(255,255,255,0.05);
            padding: 3px;
            border-radius: 6px;
        }
        .preview-device-btn {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            background: none;
            border: none;
            color: #94a3b8;
            transition: all 0.2s;
        }
        .preview-device-btn.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .preview-device-btn:hover {
            color: #fff;
        }
        body {
            padding-top: 52px;
        }
        body.mobile-preview .preview-content {
            max-width: 390px;
            margin: 0 auto;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
            min-height: calc(100vh - 52px);
            background: #f5f5f5;
        }
        body.tablet-preview .preview-content {
            max-width: 768px;
            margin: 0 auto;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
            min-height: calc(100vh - 52px);
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    {{-- Preview Toolbar --}}
    <div class="preview-toolbar" id="previewToolbar">
        <div class="preview-toolbar-left">
            <span class="preview-toolbar-badge">
                <i class="fas fa-eye"></i> Preview
            </span>
            <div>
                <div class="preview-toolbar-title">{{ $page->title }}</div>
                <div class="preview-toolbar-meta">
                    /page/{{ $page->slug }}
                    &bull; {{ $page->status === 'published' ? 'Published' : 'Draft' }}
                    &bull; Template: {{ $page->template ?? 'default' }}
                </div>
            </div>
        </div>
        <div class="preview-toolbar-right">
            {{-- Device toggle --}}
            <div class="preview-device-btns">
                <button class="preview-device-btn active" onclick="setDevice('desktop', this)" title="Desktop">
                    <i class="fas fa-desktop"></i>
                </button>
                <button class="preview-device-btn" onclick="setDevice('tablet', this)" title="Tablet">
                    <i class="fas fa-tablet-alt"></i>
                </button>
                <button class="preview-device-btn" onclick="setDevice('mobile', this)" title="Mobile">
                    <i class="fas fa-mobile-alt"></i>
                </button>
            </div>

            <a href="{{ route('admin.pages.edit', $page) }}" class="preview-toolbar-btn edit">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <a href="{{ route('admin.pages.index') }}" class="preview-toolbar-btn back">
                <i class="fas fa-arrow-left"></i> Danh sách
            </a>
        </div>
    </div>

    {{-- Preview Content — renders exactly like frontend --}}
    <div class="preview-content">
        <div class="container" style="padding-top: 20px; padding-bottom: 40px;">
            <h1 style="font-size: 22px; font-weight: 800; color: #333; margin-bottom: 16px; line-height: 1.4;">
                {{ $page->title }}
            </h1>
            <div class="shortcode-content">
                {!! $renderedContent !!}
            </div>
        </div>
    </div>

    <script>
        function setDevice(device, btn) {
            document.body.classList.remove('mobile-preview', 'tablet-preview');
            if (device === 'mobile') document.body.classList.add('mobile-preview');
            if (device === 'tablet') document.body.classList.add('tablet-preview');

            document.querySelectorAll('.preview-device-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>
</body>
</html>
