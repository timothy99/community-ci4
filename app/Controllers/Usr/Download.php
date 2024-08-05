<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Common\DownloadModel;

class Download extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    // 파일 보기 모드
    public function view()
    {
        $download_model = new DownloadModel();

        $file_id = $this->request->getUri()->getSegment(3);

        $file_info = $download_model->getFileInfo($file_id); // 파일소유권 확인 및 파일 정보 확인
        $raw_file = $download_model->getRawFile($this->response, $file_info->file_path); // 파일 다운로드

        return $raw_file;
    }

    // 파일 다운로드 모드. 이지미임에도 불구하고 다운로드가 필요한 경우가 있음.
    public function download()
    {
        $download_model = new DownloadModel();

        $file_id = $this->request->getUri()->getSegment(3);

        $file_info = $download_model->getFileInfo($file_id); // 파일소유권 확인 및 파일 정보 확인
        $file_download = $this->response->download($file_info->file_path, null)->setFileName($file_info->file_name_org); // 파일 다운로드

        return $file_download;
    }

}
