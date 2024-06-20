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

// 특정 데이터만 폼에 새로 만들어 넘긴후 html을 받아오기
function ajax4(ajax_url, div_id) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
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

// 외부에서 생성된 폼을 전체 넣기
function ajax5(ajax_url, form_data) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
        data: form_data,
        contentType: false,
        processData: false,
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

// 데이터 확인하고 메시지만 노출하기
function ajax6(ajax_url, form_id) {
    $.ajax({
        url: ajax_url,
        type: "POST",
        dataType: "json",
        data: $("#"+form_id).serialize(),
        success: function(proc_result) {
            alert(proc_result.message);
        }
    });
}

// 파일첨부 로직
function upload(file_id) {
    var form_data = new FormData($("#frm")[0]);
    form_data.append("file_id", file_id);
    $.ajax({
        data : form_data,
        type : "POST",
        url : "/csl/file/upload",
        dataType: "json",
        processData : false,
        contentType : false,
        success : function(proc_result) {
            if (proc_result.result == false) {
                alert(proc_result.message);
            } else {
                upload_after(proc_result);
            }
        }
    });
}

// 첨부파일 삭제(화면에서만)
function file_delete(file_id) {
    $("#"+file_id).remove();
    $("input[value='"+file_id+"']").val("");
}

// base64decode
function decodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split("").map(function (c) {
        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(""));
}