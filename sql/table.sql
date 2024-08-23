create table mng_session (
    id varchar(128) not null,
    ip_address varchar(45) not null,
    timestamp int unsigned not null default 0,
    data mediumblob not null,
    key ci_sessions_timestamp (timestamp),
    key id_idx (id)
) comment='CodeIgniter를 위한 db session용 테이블';

create table mng_admin (
    a_idx int not null auto_increment comment '관리자 번호',
    m_idx int not null comment '회원 번호 [mng_member.m_idx]',
    start_date varchar(14) not null comment '관리자 권한 부여일',
    end_date varchar(14) not null default '99991231235959' comment '관리자 권한 삭제일',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (a_idx),
    unique key member_idx (m_idx)
) comment='관리자 권한 부여';

create table mng_board (
    b_idx int not null auto_increment comment '게시물 번호',
    board_id varchar(20) default null comment '게시판 아이디',
    category varchar(20) default null comment '카테고리',
    title varchar(1000) not null comment '제목',
    contents text not null comment '내용',
    http_link varchar(500) default null comment '인터넷 링크',
    file_idxs varchar(4000) null comment '파일 인덱스들',
    comment_cnt int not null default 0 comment '댓글 등록수',
    heart_cnt int not null default 0 comment '공감수',
    hit_cnt int not null default 0 comment '조회수',
    reg_date varchar(14) null comment '등록일-정렬을 위해 사용자가 입력한 날짜',
    notice_yn enum('Y', 'N') not null default 'N' comment '공지 여부',
    del_yn enum('Y', 'N') not null default 'N' comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (b_idx),
    key board_id (board_id)
) comment='게시판';

-- alter table mng_board add reg_date varchar(14) null comment '입력일-정렬을 위해 사용자가 입력한 날짜' after hit_cnt;
-- alter table mng_board add notice_yn enum('Y', 'N') not null default 'N' comment '공지 여부' after reg_date;

create table mng_board_comment (
    bc_idx int not null auto_increment comment '인덱스',
    b_idx int not null comment '게시물 번호 [mng_board.b_idx]',
    comment varchar(4000) not null comment '댓글',
    del_yn enum('Y', 'N') not null comment '삭제 여부',
    ins_id varchar(70) default null comment '입력자 [mng_member.m_idx]',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) default null comment '수정자 [mng_member.m_idx]',
    upd_date varchar(14) not null comment '수정일',
    primary key (bc_idx)
) comment='게시판 댓글';

-- drop table mng_board_config;
create table mng_board_config (
    bc_idx int not null auto_increment comment '인덱스',
    board_id varchar(20) default null comment '게시판 아이디',
    type varchar(100) default null comment '타입(스킨)',
    category varchar(300) default null comment '카테고리',
    category_yn varchar(1) null comment '카테고리 사용여부',
    user_write varchar(1) default 'Y' not null comment '사용자가 글쓰기 가능하게 할지 여부',
    title varchar(1000) not null comment '제목',
    base_rows int not null comment '화면에 기본으로 보여줄 줄 수',
    reg_date_yn varchar(1) null comment '입력일 수정 기능 사용 여부',
    file_cnt int not null comment '최대 첨부파일 업로드 수',
    file_upload_size_limit int null comment '최대 파일 업로드 용량 제한(서버 설정에 영향을 받는다.)',
    file_upload_size_total int null comment '총 파일 업로드 용량 제한(서버 설정에 영향을 받는다.)',
    del_yn enum('Y', 'N') not null default 'N' comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (bc_idx),
    key board_id (board_id)
) comment='게시판 설정 관리';

-- alter table mng_board_config add user_write varchar(1) default 'Y' not null comment '사용자가 글쓰기 가능하게 할지 여부' after category_yn;

create table mng_file (
    f_idx int not null auto_increment comment '연번',
    file_id varchar(32) default null comment '파일 불러오기를 위한 id',
    file_name_org varchar(1000) not null comment '원본 파일명',
    file_directory varchar(10) not null comment '저장된 파일의 경로(연/월)',
    file_name_uploaded varchar(1000) not null comment '저장된 파일 전체 경로',
    file_size int not null comment '파일 크기',
    file_ext varchar(10) default null comment '파일확장자',
    image_width int not null default 0 comment '가로해상도(이미지)',
    image_height int not null default 0 comment '세로해상도(이미지)',
    mime_type varchar(200) not null comment '파일 mime type',
    category varchar(100) not null comment '사용자가 지정한 파일 형식',
    del_yn enum('Y', 'N') not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자 [mng_member.m_idx]',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자 [mng_member.m_idx]',
    upd_date varchar(14) not null comment '수정일',
    primary key (f_idx),
    unique key file_id (file_id)
) comment='파일 정보';

/*
    alter table mng_file add file_ext varchar(10) default null comment '파일확장자' after file_size;
*/

create table mng_member (
    m_idx int not null auto_increment comment '인덱스',
    member_id varchar(64) not null comment '사용자 아이디',
    member_password varchar(1000) not null comment '암호',
    member_name varchar(60) not null comment '이름',
    member_nickname varchar(60) not null comment '별명',
    email varchar(100) default null comment '이메일',
    phone varchar(13) default null comment '휴대전화 번호',
    gender varchar(1) default null comment '성별',
    post_code varchar(5) default null comment '우편번호',
    addr1 varchar(200) default null comment '주소1',
    addr2 varchar(200) default null comment '주소2',
    join_type varchar(10) default null comment '가입경로(sns등)',
    email_yn enum('Y', 'N') not null comment '이메일 수신여부',
    post_yn enum('Y', 'N') not null comment '우편물 수신 여부',
    sms_yn enum('Y', 'N') not null comment 'sms 수신 여부',
    auth_group varchar(20) not null comment '권한 그룹',
    last_login_date varchar(14) not null comment '최종 로그인 시간',
    last_login_ip varchar(15) default null comment '마지막 로그인 ip',
    del_yn enum('Y', 'N') not null comment '삭제 여부',
    ins_id varchar(70) default null comment '입력자 [mng_member.m_idx]',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) default null comment '수정자 [mng_member.m_idx]',
    upd_date varchar(14) not null comment '수정일',
    primary key (m_idx),
    unique key mem_usr_id (member_id)
) comment='회원정보';

create table mng_bulk
(
    b_idx int auto_increment comment '대량작업 인덱스' primary key,
    title varchar(1000) not null comment '제목',
    bulk_file varchar(32) null comment '대량작업 파일',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '대량입력 메타';

create table mng_bulk_detail (
    bd_idx int auto_increment comment '대량작업 상세 인덱스' primary key,
    b_idx int not null comment '대량작업 인덱스',
    data_json varchar(8000) default null comment 'json데이터',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '대량입력 상세정보';

create index mng_bulk_detail_b_idx_index on mng_bulk_detail (b_idx);

create table mng_contents (
    c_idx int auto_increment comment '콘텐츠 인덱스' primary key,
    contents_id varchar(50) default null comment '콘텐츠 아이디',
    title varchar(1000) not null comment '제목 - 구분용이며 페이지 기능에서는 사용하지 않음',
    contents varchar(4000) not null comment '내용',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '콘텐츠';

/*
alter table mng_contents add contents_id varchar(50) default null comment '콘텐츠 아이디' after c_idx;
*/

create table mng_menu (
    m_idx int not null auto_increment comment '인덱스',
    upper_idx int not null default 0 comment '상위 인덱스',
    idx1 int not null default 0 comment '인덱스1',
    idx2 int not null default 0 comment '인덱스2',
    idx3 int not null default 0 comment '인덱스3',
    order_no int not null default 0 comment '정렬순서',
    menu_position int not null default 0 comment '메뉴 위치',
    menu_name varchar(500) null comment '메뉴명',
    http_link varchar(500) null comment '외부 링크',
    del_yn enum('Y', 'N') not null comment '삭제 여부',
    ins_id varchar(70) default null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) default null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (m_idx),
    key idx1 (idx1, idx2, idx3)
) comment='메뉴';

create table mng_menu_json (
    mj_idx int not null auto_increment comment '인덱스',
    category varchar(500) null comment '분류',
    menu_json text null comment 'json형태의 메뉴 정보',
    del_yn enum('Y', 'N') not null comment '삭제 여부',
    ins_id varchar(70) default null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) default null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (mj_idx)
) comment='json 형태의 메뉴 저장내용';

create table mng_member_reset (
    mr_idx int not null auto_increment comment '인덱스',
    member_id varchar(64) not null comment '사용자 아이디',
    email varchar(100) default null comment '이메일',
    reset_key varchar(32) default null comment '리셋키',
    expire_date varchar(14) not null comment '암호화 변경 만료 시간(현재 시간으로부터 15분)',
    primary key (mr_idx),
    key mng_member_reset_reset_key (reset_key)
) comment='암호를 초기화 하기 위한 정보';

create table mng_slide (
    s_idx int auto_increment comment '슬라이드 인덱스' primary key,
    title varchar(1000) not null comment '제목',
    contents varchar(4000) not null comment '내용-슬라이드에선 실제 내용 출력되지 않으므로 alt내용을 의미함',
    http_link varchar(1000) not null comment 'http 링크',
    order_no int null comment '순서',
    slide_file varchar(32) null comment '슬라이드 이미지',
    start_date varchar(14) default '20000101000000' not null comment '게시 시작시간',
    end_date varchar(14) default '99991231235959' not null comment '게시 종료시간',
    display_yn enum ('Y', 'N') default 'Y' not null comment '노출 여부',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '슬라이드';

create table mng_popup (
    p_idx int auto_increment comment '팝업 인덱스' primary key,
    title varchar(1000) not null comment '제목',
    popup_file varchar(32) null comment '레이어 팝업 이미지',
    http_link varchar(1000) not null comment 'http 링크',
    position_left int null comment '좌측 위치',
    position_top int null comment '상단 위치',
    popup_width int null comment '너비',
    popup_height int null comment '높이',
    disabled_hours int null comment '다시 보지 않음 누를시 안보이는 시간',
    start_date varchar(14) default '20000101000000' not null comment '게시 시작시간',
    end_date varchar(14) default '99991231235959' not null comment '게시 종료시간',
    display_yn enum ('Y', 'N') default 'Y' not null comment '노출 여부',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '레이어 팝업';

create table mng_ask (
    a_idx int auto_increment comment '문의 인덱스' primary key,
    name varchar(200) not null comment '이름',
    contents varchar(4000) default null comment '내용',
    phone varchar(32) not null comment '전화',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_date varchar(14) not null comment '입력일',
    upd_date varchar(14) not null comment '수정일'
) comment '단순문의';

/*
alter table mng_ask add contents varchar(4000) default null comment '내용' after name;
*/

create table mng_shortlink (
    sl_idx int not null auto_increment comment '단축url 인덱스',
    title varchar(1000) not null comment '제목',
    http_link varchar(1000) not null comment '이동할 링크',
    del_yn enum('Y', 'N') not null default 'N' comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (sl_idx)
) comment='단축url';

create table mng_privacy (
    p_idx int auto_increment comment '인덱스' primary key,
    http_link varchar(1000) not null comment '링크',
    memo varchar(2000) not null comment '상담메모',
    ip_addr varchar(15) not null comment 'IP주소',
    del_yn enum ('Y', 'N') default 'N' not null comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일'
) comment '개인정보 처리시스템';

create index tbl_privacy_ins_id_idx on mng_privacy (ins_id);
create index tbl_privacy_upd_id_idx on mng_privacy (upd_id);

-- drop table mng_youtube;
create table mng_youtube (
    y_idx int not null auto_increment comment '인덱스',
    title varchar(200) not null comment '제목',
    category varchar(30) not null comment '채널형인지 재생목록형인지',
    play_id varchar(500) not null comment '채널 또는 재생목록의 아이디',
    del_yn enum('Y', 'N') not null default 'N' comment '삭제 여부',
    ins_id varchar(70) not null comment '입력자',
    ins_date varchar(14) not null comment '입력일',
    upd_id varchar(70) not null comment '수정자',
    upd_date varchar(14) not null comment '수정일',
    primary key (y_idx)
) comment='유튜브 재생 목록';

create index mng_youtube_play_id on mng_youtube (play_id);