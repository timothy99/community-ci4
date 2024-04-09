var summernote_settings = {
    height: 300, // 높이
    focus: true, // 로딩후 포커스 이동
    lang: "ko-KR", // 언어파일
    codeviewFilter: false, // XSS 필터
    codeviewIframeFilter: true, // iframe필터
    callbacks : { 
        onImageUpload : function(files) { // 파일 업로드(다중업로드를 위해 반복문 사용)
            for (var i = files.length-1; i >= 0; i--) {
                uploadSummernoteFile(files[i]);
            }
        }
    },
};

// 썸머노트 파일 첨부 로직
function uploadSummernoteFile(file) {
    formData = new FormData();
    formData.append("attach", file);
    $.ajax({
        data : formData,
        type : "POST",
        url : "/csl/file/upload",
        dataType: "json",
        processData : false,
        contentType : false,
        success : function(proc_result) {
            var result = proc_result.result;
            var message = proc_result.message;
            if (result == false) {
                alert(message);
            } else {
                var file_html = proc_result.file_html;
                $("#contents").summernote("pasteHTML", file_html);
            }
        }
    });
}