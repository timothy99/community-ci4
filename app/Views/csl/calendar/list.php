<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>일정관리</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" id="calendar">

                </div>
            </div>
            <div class="card-footer clearfix d-flex justify-content-end">
                <a href="/csl/calendar/write">
                    <button type="button" class="btn btn-info">일정등록</button>
                </a>
            </div>
        </div>
    </section>
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-calendar-list").addClass("menu-open");
        $("#a-calendar-list").addClass("active");
    });

    // 달력생성
    $(function () {
        cal();
    });

    function cal() {
        var date = new Date()
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var calendar_elemenet = document.getElementById("calendar");
        var calendar_render = new Calendar(calendar_elemenet, {
            eventClick: function(info) { // 이벤트 클릭시 대관 보기로 가기
                location.href = "/csl/calendar/view?no="+info.event.id;
            },
            headerToolbar: {
                left: "",
                center: "title",
                right: "prev today next"
            },
            themeSystem: "bootstrap",
            locale: "ko",
            events: {
                url: "/csl/calendar/month",
                method: "POST",
            },
            contentHeight:"auto",
        });
        calendar_render.render();
    }
</script>