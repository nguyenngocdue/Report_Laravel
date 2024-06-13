<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HtmlConversionController extends Controller
{
    public function convertToTailwind(Request $request)
    {
        dd($request);
        $content = $request->input('content');

        $convertedContent = $this->convertHtmlToTailwind($content);
        return response()->json(['convertedContent' => $convertedContent]);
    }

    private function convertHtmlToTailwind($content)
    {
        $nodePath = '/usr/bin/node'; // Đường dẫn đến Node.js, bạn cần kiểm tra đúng đường dẫn trên hệ thống của bạn
        $scriptPath = base_path('convertHtmlToTailwind.js');

        // Kiểm tra tồn tại của Node.js và scriptPath
        if (!file_exists($nodePath)) {
            throw new \Exception('Node.js không tồn tại tại đường dẫn: ' . $nodePath);
        }

        if (!file_exists($scriptPath)) {
            throw new \Exception('Script không tồn tại tại đường dẫn: ' . $scriptPath);
        }

        $process = new Process([$nodePath, $scriptPath, $content]);
        $process->run();

        // Kiểm tra xem process có thành công hay không
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
