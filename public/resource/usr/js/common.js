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