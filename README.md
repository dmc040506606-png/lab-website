# 한양대학교 RNA Genomics 연구실 홈페이지

`rnagenomics.or.kr` (그누보드5 + PHP + MySQL) 을 **정적 HTML 사이트**로 옮긴 것입니다.
서버도, 데이터베이스도, 관리자 로그인도 없습니다. 파일만 있으면 어디서든 돌아갑니다.

## 페이지

| 파일 | 메뉴 |
|---|---|
| `index.html` | Home |
| `professor.html` | Professor |
| `members.html` | Members → Lab Members |
| `alumni.html` | Members → Alumni |
| `research.html` | Research |
| `publications.html` | Publication |
| `gallery.html` | Gallery |
| `contact.html` | Contact Us |

기존 사이트의 `Before 2019`, `Board`, `Research > Past` 세 메뉴는 **원래 게시판이 존재하지
않거나 글이 0건**이어서 뺐습니다. 나중에 내용이 생기면 다시 추가하면 됩니다.

## 폴더

```
css/       디자인 (원본 그대로 사용)
skin/      게시판별 레이아웃 스타일
           - student     구성원 카드
           - alumni      졸업생
           - rsh_html    연구
           - publication_img  논문 목록
           - gallery2    갤러리 격자
js/        슬라이더·메뉴·스크롤 애니메이션
fonts/     SCoreDream 한글 웹폰트
webfonts/  아이콘 폰트 (Font Awesome)
images/    디자인 이미지 (로고, 배경 등)
img/       버튼·아이콘 이미지
sub_menu/  서브페이지 상단 배너 이미지
favicon/   브라우저 탭 아이콘
data/      본문에 들어간 사진·그림
```

**인터넷 연결 없이도 그대로 보입니다.** 외부 서버에서 받아오던 파일(jQuery, 애니메이션,
아이콘)을 전부 이 폴더 안에 넣었습니다. 남은 외부 연결은 지도와 한양대 링크뿐입니다.

## 고치고 싶을 때

Claude에게 말하면 됩니다. 파일을 직접 열 필요 없습니다.

> 구성원에 OOO 추가해줘. 박사과정이고 2026년 3월 입학, 이메일은 ...

> 논문 3편 추가해줘 (PDF나 목록 첨부)

> 메인 화면 첫 번째 사진을 이걸로 바꿔줘

고쳐진 파일을 GitHub에 올리면 1~2분 뒤 반영됩니다.

## GitHub 올리는 법

1. 저장소 첫 화면 → **Add file → Upload files**
2. 바뀐 파일을 끌어다 놓기 (같은 이름이면 덮어써짐)
3. 아래 **Commit changes**

`data/` 나 `images/` 안의 파일을 바꿀 때는 **그 폴더로 먼저 들어간 다음** 업로드해야 합니다.

## 주의

- `CNAME` 파일이 생기면 **지우지 마세요.** 지우면 연결된 주소가 끊깁니다.
- 파일 이름은 대소문자를 구분합니다. `Photo.JPG` 와 `photo.jpg` 는 다른 파일입니다.
- 이 저장소는 공개(Public)입니다. **미공개 연구 데이터나 개인정보는 올리지 마세요.**

## 원본 자료

이관 전 백업은 저장소에 넣지 않았습니다. 아래 위치에 있습니다.

```
홈페이지\26년 12월 09일 이후\
├── 디자인소다 업체에 요청\      업체가 보낸 웹파일 전체 + DB 덤프
└── Claude로 홈페이지 백업\      크롤링 백업 + DB에서 뽑은 페이지별 본문
```
