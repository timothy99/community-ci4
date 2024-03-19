// 입력받은 form 데이터로 처리
function ajax1(ajax_url, form_id) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
        data: $("#"+form_id).serialize(),
        success: function(proc_result) {
            var result = proc_result.result;
            var message = proc_result.message;
            var return_url = proc_result.return_url;
            if(result == true) {
                location.href = return_url;
            } else {
                alert(message);
            }
        }
    });
}

// 입력받은 데이터 없이 url의 세그멘트로만 처리
function ajax2(ajax_url) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
        success: function(proc_result) {
            var result = proc_result.result;
            var message = proc_result.message;
            var return_url = proc_result.return_url;
            if(result == true) {
                location.href = return_url;
            } else {
                alert(message);
            }
        }
    });
}

// 폼 전체 정보를 받아서 만들어야할 html만 생성후 해당 위치에 html입력
function ajax3(ajax_url, form_id, div_id) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
        data: $("#"+form_id).serialize(),
        success: function(proc_result) {
            var result = proc_result.result;
            var message = proc_result.message;
            var return_html = proc_result.return_html;
            if(result == true) {
                $("#"+div_id).html(return_html);
            } else {
                alert(message);
            }
        }
    });
}

// 파일첨부 로직
function upload(file_id) {
    var formData = new FormData();
    var file = $("#"+file_id)[0].files[0];
    formData.append("file", file);
    $.ajax({
        data : formData,
        type : "POST",
        url : "/csl/attach/upload",
        dataType: "json",
        processData : false,
        contentType : false,
        success : function(proc_result) {
            var result = proc_result.result;
            var message = proc_result.message;
            var file_id = proc_result.file_id;
            var down_html = proc_result.down_html;
            if (result == false) {
                alert(message);
            } else {
                $("#ul_file_list").append("<li id='"+file_id+"'><input type='hidden' id='file_list' name='file_list[]' value='"+file_id+"'></li>");
                $("#visible_file_list").append("<li id='"+file_id+"'>"+down_html+"&nbsp;&nbsp;&nbsp; <a id='"+file_id+"' href='javascript:void(0)' onclick='file_delete(\""+file_id+"\")'>삭제</a></li>");
            }
        }
    });
}

// 첨부파일 삭제(화면에서만)
function file_delete(file_id)
{
    $("#"+file_id).remove();
}