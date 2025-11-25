# community-ci4
코드이그나이터 프레임워크로 개발된 커뮤니티 기능을 하는 프로그램의 readme 입니다.

## 기본설정

### env 설정
1. env파일을 .env로 복사합니다.
2. DB설정을 합니다.
3. 설명에 따라 기타 필요한 사항들을 입력합니다.

### App.php 설정
* index.php가 주소줄에 보이는것을 방지하기 위해 40번 라인의 public $indexPage 를 널로 변경
```
public $indexPage = 'index.php'     ->      public $indexPage = 'index.php'
```

### Events.php 설정
* 이미 설정은 되어 있습니다. 설명을 위해 추가합니다.
    - 기본 언어설정 팩 추가
    - 쿼리가 실행되고 나면 logModifyQuery(); 함수를 실행하도록 이벤트 추가
    - 기본 권한설정 기능이 실행되도록 Authority_model 추가

#### Constants.php 설정
* 추가로 설정해야 하는 함수는 다음과 같습니다.
    - CSS_VER : CSS버전
    - JS_VER : JS버전
    - PROGRAM_VER : 메뉴 하단의 프로그램 버전 릴리즈 될때마다 변경하면 됩니다.
    - SITE_NAME : 사이트 명칭
    - UPLOADPATH : 파일 업로드 경로

## 디렉토리 구성 및 일부 필수 수정해야할 파일 목록
* 위 내용을 정리해둔 것으로 이중 헬퍼는 설명된것 외에 추가로 더 있습니다. 헬퍼등 각 파일에 대한 설명은 파일 내의 주석을 확인하시기 바랍니다.
```
+-- Config                      # 설정파일
|   └-- App.php                 # App 기본설정, 사이트별 설정은 여기에서 하지 말고 .env파일에서 설정하도록 한다.
|   └-- Constants.php           # 시스템 기본 상수 설정
|   └-- Events.php              # 프로그램이 최초 작동할때 실행되어야 할 함수들
|   └-- Routes.php              # 프로그램이 실행될때의 기능 get, post, cli등으로 구분된다.
+-- Helpers
|   └-- logging_helper.php      # 쿼리 로깅등을 지원해 주는 헬퍼
|   └-- session_helper.php      # 세션을 편리하게 사용하기 위한 세션 헬퍼
+-- Controller
|   └-- Csl                     # 관리자 컨트롤러
|   └-- Usr                     # 사용자 컨트롤러
+-- Model
|   └-- Csl                     # 관리자 모델
|   └-- Usr                     # 사용자 모델
+-- Views
|   └-- csl                     # 관리자 뷰
|   └-- usr                     # 사용자 뷰
+-- .env                        # 각종환경설정 파일
+-- README.md                   # 지금보고 있는 파일
```
