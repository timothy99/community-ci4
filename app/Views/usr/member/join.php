    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">회원가입</h1>
                                    </div>
                                    <form id="frm" name="frm" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_id" name="member_id" placeholder="아이디">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="암호">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user" id="member_password_confirm" name="member_password_confirm" placeholder="암호 재입력">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_name" name="member_name" placeholder="이름">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_nickname" name="member_nickname" placeholder="별명">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="phone" name="phone" placeholder="전화번호">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="이메일주소">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="post_code" name="post_code" placeholder="우편번호" readonly>
                                            </div>
                                            <div class="col-sm-6">
                                                <button type="button" class="btn btn-info btn-user btn-block" onclick="postcode_open()">검색</button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                                                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="postcode_close()" alt="접기 버튼">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="addr1" name="addr1" placeholder="주소" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="addr2" name="addr2" placeholder="상세주소">
                                        </div>
                                        <button type="button" id="signup" name="signup" class="btn btn-primary btn-user btn-block">
                                            가입하기
                                        </button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="/member/forgot">암호를 잊었어요</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/member/login">이미 가입하셨나요?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    $(function() {
        $("#signup").click(function() {
            ajax1("/member/signup", "frm");
        });
    });
</script>