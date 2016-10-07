@charset "utf-8";
/* CSS Document */

/* GLOBAL
----------------------------------------------------------------------------------------------------*/
body {
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	font-size: 0.8rem;
	line-height: 1.6;
	background: #000;
	color: #efefef;
}
h1, h2, h3, h4, h5, h6 {
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	color: #efefef;
}
h6 {
	font-size: 0.8rem;
}
a, a:visited, a:focus {
	color:#fff;
	text-decoration:none;
	outline:none;
	/*-webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;*/
}
a:hover {
	color:#fff;
	text-decoration:underline;
}
ul, ol, dl {
	font-size: 0.8rem;
}
ul {
	list-style-type:square;
}
p {
	font-size: 0.8rem;
	font-weight: normal;
	line-height: 1.6;
	text-align: justify;
}

table {
	border: 0;
	background: none;
}
table {
    border-collapse: separate;
    border-spacing: 4px;
}
table tr.even, table tr.alt, table tr:nth-of-type(2n) {
	background: none;
}
table tbody tr th {
	font-weight: bold;
}
table tbody tr th, table tbody tr td {
	vertical-align: top;
	font-size: 0.8rem;
	line-height: 1.5;
	color: #efefef;
	padding: 5px 9px;
    background:#202020;
}
label {
	font-size: 0.8rem;
	color: #efefef;
}
input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="color"], textarea {
	font-size: 0.8rem;
}
input[type="submit"].button {
	border-radius: 4px;
}
input[type="submit"].button:hover {
}
textarea {
	margin-bottom: 1rem;
}
select {
	background-image: none;
	margin-bottom: 1rem;
}
hr {
	border-color: #252525;
}
.button, a.button {
	font-family: "Open Sans","Microsoft YaHei New","Microsoft Yahei","微软雅黑",宋体,SimSun,STXihei,"华文细黑",sans-serif;
	font-weight:bold;
	font-size:0.82rem;
	padding:0.6rem 1.2rem;
	color: #fff;
	border-radius: 4px;
	background-color: #c00;
}
.button:hover, .button:focus {
	background-color: #c00;
}
.section_separator {
	margin-bottom:1rem;
	border-bottom:1px dotted #e0e0e0;
	padding-bottom:1rem;
}
.disabled {
	background-color:#efefef;
}
.disappear {
	display: none;
}

/*
h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
	font-family: 'SourceSansProBold';
	display:block;
	font-weight:normal;
}
h1, .h1 {
	font-size:22px;
	margin:0 0 15px;
	padding:0;
	color:#0058B0;
}
h2, .h2 {
	font-size:17px;
	margin:0 0 7px;
	padding:0;
}
h3, .h3 {
	font-size:14px;
	margin:17px 0 7px;
	padding:0;
	color:#0058B0;
}
h4, .h4 {
	font-size:12px;
	margin:17px 0 7px;
	padding:0;
	color:#363636;
}
th, td {
	padding:3px;
}
th {
	text-align:left;
}
.error ul {
    margin: 5px 0;
    padding-left: 15px;
}
.error ul li {
	line-height: 18px;
    margin-bottom: 5px;
}*/

/* COMMON BLOCKS
----------------------------------------------------------------------------------------------------*/
.common_block {
	padding:0.8rem 1.6rem;
    background-color:#151515;
    height: inherit;
    margin-bottom: 0.67rem;
}
.common_block h2 {
	font-weight: bold;
	font-size: 1.05rem;
}
.common_block ul li {
	margin-bottom: 0.33rem;
}
.row.bg_table {
	border-top: 1px solid #333;
	border-left: 1px solid #333;
}
.row.bg_table .columns {
	border-right: 1px solid #333;
	border-bottom: 1px solid #333;
}

@media only screen and (max-width: 40em) {
	.common_block {
		background-color: transparent;
	}
}

/* WIDGETS
----------------------------------------------------------------------------------------------------*/
.widget {
	background:#efefef;
	padding:1rem 1.33rem;
	display:block;
	margin-bottom:0.67rem;
}
.widget h1 {
	border-bottom: 1px dotted #C5C5C5 !important;
    color: #454545 !important;
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    margin: 0 0 0.67rem !important;
    padding-bottom: 0.27rem !important;
    text-transform: uppercase !important;
}
.widget ul:last-child {
	margin-bottom: 0;
}
.widget ul li {
    font-size: 0.8rem;
    margin-bottom: 0.67rem;
}
.widget ul.simple_list li {
    margin-bottom: 0.33rem;
}
.widget ul li .subtitle {
	color: #999;
    display: block;
    font-size: 0.75rem;
}
.widget ul li li, .widget ol li li {
	margin: 0.33rem 0;
}
.widget .more_link {
	margin-top: 1.33rem;
}
.widget .more_link a {
    font-size: 0.75rem;
	color: #909090;
}
.reveal-modal {
	background: rgba(0,0,0,0.85);
	border: 1px solid #333;
}
/* TABLE
----------------------------------------------------------------------------------------------------*/
.table_header {
	background-color: #202020;
	border-top: 1px solid #202020;
	border-left: 1px solid #202020;
}
.table_row {
	border-top: 1px solid #202020;
	border-left: 1px solid #202020;
}
.table_row > .columns {
	border-right: 1px solid #202020;
	border-bottom: 1px solid #202020;
}
.table_row span.small-label {
	margin-right:5px;
	width: 25%;
	min-width: 120px;
	font-weight: bold;
}

@media only screen and (max-width: 64em) {
	.table_row span.small-label {
		display: inline-block !important;
	}
	.table_row span.small-label-long {
		display: block !important;
	}
}


/* HEADER
----------------------------------------------------------------------------------------------------*/
#header_wrapper {
}
#header_wrapper .tab-bar h1 {
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	font-weight: normal;
	font-size: 0.9rem;
}
#header_wrapper ul.off-canvas-list li label {
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	font-weight: normal;
}
#header_wrapper ul.off-canvas-list li a {
	padding: 0.66667rem 0.9375rem;
}
#header {
	max-width: 1140px;
	padding:0.8rem 0 0.4rem;
}
#header #top_links {
	margin-top:0.3rem;
}
#header #logo {
}
#header #welcome {
	display: inline-block;
    /*margin-right: 1.33rem;*/
}
#header .separator {
	margin: 0 0.35rem;
}

#member_in_box {
	display: block;
	margin: 1rem 0;
}
#member_in_box a {
    <?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
    background-color: <?php echo $_SESSION['agent']['BackgroundColour']; ?>;
    <?php } else { ?>
    background-color: #202020; 
    <?php } ?>
    //background-color: #202020;
    border-radius: 4px;
    padding: 5px 10px;
}

@media only screen and (max-width: 64em) {
	#header {
		padding:0.4rem 0 1rem;
	}
}

/* TOP NAVIGATION
----------------------------------------------------------------------------------------------------*/
#nav_main {
	margin-top: 0.5rem;
	margin-bottom: 1rem;
}
#nav_main.contain-to-grid {
	background: #efefef;
}
#nav_main .top-bar {
	max-width: 1140px;
	background-color: #efefef;
}
#nav_main .top-bar-section ul li {
	background-color: #efefef;
}
#nav_main .top-bar-section ul li > a {
	color: #3d3d3d;
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
    font-size: 0.8rem;
}
#nav_main .top-bar-section > ul > li > a {
	font-size: 0.9rem;
}
#nav_main .top-bar-section ul li.active > a {
	color: #007CF9;
}
#nav_main .top-bar-section li:not(.has-form) a:not(.button) {
	background-color: transparent;
}
#nav_main .top-bar-section li:not(.has-form) a:not(.button):hover {
	background: #e0e0e0;
}
#nav_main .top-bar-section .has-dropdown > a {
	padding-right: 2.18rem !important;
}
#nav_main .top-bar-section ul li:hover:not(.has-form) > a {
	color: #0058B0;
}
#nav_main .no-js .top-bar-section ul li:hover > a {
	color: #0058B0;
}
#nav_main .top-bar-section .has-dropdown > a::after {
	border-color: rgba(0, 0, 0, 0.65) transparent transparent;
	border-width: 4px;
	top: 1.45625rem;
}
#nav_main .top-bar-section .dropdown {
	top: 44px;
	background-color: #f7f7f7;
}
#nav_main .top-bar-section .dropdown .dropdown {
	top: 0;
	background-color: #f7f7f7;
}

/* BREADCRUMB
----------------------------------------------------------------------------------------------------*/
/*.breadcrumbs {
	border: none;
	border-radius: 0;
    margin-bottom: 1rem;
    background: transparent;
    padding: 0px;
}
.breadcrumbs > * {
	text-transform: none;
    font-size: 0.7rem;
    line-height: 1rem;
}
.breadcrumbs > *:before {
	color: #777;
    content: ">";
    margin: 0 0.4rem;
    top: 1px;
}
.breadcrumbs > * a {
	color: #007CF9;
}
.breadcrumbs > * a:hover {
	color: #0058B0;
}
.breadcrumbs > .current a {
	color: #777;
}
.breadcrumbs > *:hover a, .breadcrumbs > *:focus a {
	text-decoration: none;
}*/

.breadcrumb_box {
    font-size: 12px;
    margin-bottom: 20px;
    padding: 7px 0;
}
.breadcrumb_box .breadcrumb_divider {
    margin: 0 6px;
}
.breadcrumb_box a {
}
.breadcrumb_box a:hover {
}

/* MAIN FRAMES
----------------------------------------------------------------------------------------------------*/
#main_wrapper {
	max-width: 1140px;
	margin-bottom: 1.5rem;
}
#main_wrapper #main_content_wrapper {
	margin-bottom: 1rem;
}
#main_wrapper #main_content_wrapper > h1 {
    margin: 0 0 0.6rem;
    text-transform: uppercase;
    font-size: 1rem;
}
#main_wrapper #main_content_wrapper h2 {
	font-size: 1.05rem;
}





/* FOOTER
----------------------------------------------------------------------------------------------------*/
#footer_wrapper {
	background-color: #262626;
	padding: 1.5rem 0;
	margin-top: 1rem;
	color: #fff;
	font-size: 0.75rem;
}
#footer_wrapper #footer {
	max-width: 1140px;
}
#footer_wrapper #footer h1 {
	color: #fff;
	margin:0 0 0.5rem;
	font-size: 1.2rem;
}
#footer_wrapper #footer ul {
	list-style: none;
	margin-left: 0;
}
#footer_wrapper #footer ul li {
	margin-bottom: 0.33rem;
}
#footer_wrapper #footer a {
	color: #4aa5ff;
}
#footer_wrapper #footer a:hover {
	color: #007cf9;
}
#footer_wrapper #footer_bottom {
	margin:1rem 0;
}

/* PAGINATION
----------------------------------------------------------------------------------------------------*/
.pagination_wrapper {
	display: inline-block;
    margin-bottom: 0;
}
.pagination_wrapper .pagination li.current a {
	background: #007cf9;
}
.pagination_wrapper .pagination li {

}
.pagination_wrapper .pagination li > a {
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	font-size: 0.8rem;
	color: #efefef;
	padding:0.08rem 0.4rem;
	background: #222
}
.pagination_wrapper .pagination li > a:hover, .pagination_wrapper .pagination li > a:focus {
	background: #222;
}
.pagination_wrapper .pagination li.current a {
	background: #c00;
	text-decoration: none;
}
.pagination_wrapper .pagination li.current a:hover, .pagination li a:hover {
	background: #c00;
	text-decoration: none;
}
.pagination_wrapper .pagination li.disabled {
	background-color: transparent;
}
.pagination_wrapper .pagination li.disabled > a {
  background: none repeat scroll 0 0 #222;
  color: #555;
  cursor: default;
  text-decoration: none;
}
.pagination_wrapper .pagination li.dots > a {
  background: none repeat scroll 0 0 #222;
  color: #303030;
  cursor: default;
}

/* FORM
----------------------------------------------------------------------------------------------------*/
.common_form {
}
.common_form.common_block {
	padding:1.5rem 2rem;
}
.common_form textarea {
	height: 10rem;
}
.common_form hr {
	margin: 0 0 1rem;
}
.label_required {
	color: #CC0000;
    display: inline-block;
    margin-left: 0.2rem;
}
@media only screen and (max-width: 64em) {
	.common_form label.inline, .common_form label.inline-long {
		margin: 0 0 0.3rem;
		padding: 0;
	}
}
@media only screen and (max-width: 40em) {
	.common_form.common_block {
		padding:1.5rem 0;
	}
}


/* VALIDATION
----------------------------------------------------------------------------------------------------*/
#frm label.error {
	margin-left: 10px;
	width: auto;
	display: inline;
}
form.cmxform label.error, label.error {
	/* remove the next line when you have trouble in IE6 with labels in list */
	color: #c22;
	margin-left:7px;
	font-style: italic
}
.block {
	display: block;
}
form.cmxform label.error {
	display: none;
}

/* CRUD SEACRH
----------------------------------------------------------------------------------------------------*/
#search_box {
	padding:15px 20px 10px;
	border:3px solid #2d2d2d;
	border-radius:6px;
	background-color:#202020;
	margin-bottom:22px;
}
.search_initial {
	border: 3px solid #2d2d2d !important;
	background-color:#202020 !important;
    border-radius: 0 0 0 0 !important;
}
#search_box h2 {
	display: inline-block;
	margin-bottom:0;
}
#search_box #search_trigger_box {
	display: inline-block;
    font-size: 11px;
    margin-left: 6px;
    position: relative;
    top: -1px;
}
#search_box #search_content {
	margin-top:5px;
}
#search_box table {
	width:100%;
}

/* MEMBER
----------------------------------------------------------------------------------------------------*/
.member_table {
	border-bottom:1px solid #ddd;
	border-right:1px solid #ddd;
	width:100%;
	margin-top:10px;
}
.member_table a {
}
.member_table th {
	text-align:left;
	padding:1rem 1.33rem;
	background-color:#444;
	color:#fff;
	border: 1px solid #444;
	border-bottom: 0;
}
.member_table td {
	padding:1rem 1.33rem;
	border-left:1px solid #ddd;
}
.member_table_nocell th {
	text-align:left;
	padding:7px 5px 3px;
	vertical-align:top;
	min-width:90px;
}
.member_table_nocell td {
	padding:3px 5px;
}
.member_table_right {
	border-right:1px solid #ddd;
}
.member_table tr:nth-child(odd) {
}
.member_table tr:nth-child(even) {
 background:rgba(204, 204, 204, 0.25);
}
.member_results {
}
.member_results .results_left {
	float:left;
}
.member_results .results_right {
	float:right;
	text-align:right;
	padding-top:4px;
}
.member_results .results_right a {
	margin-left:0;
}

/* MERCHANT
----------------------------------------------------------------------------------------------------*/
/*.merchant_table {
	border-bottom:1px solid #ddd;
	border-right:1px solid #ddd;
	width:100%;
	margin-top:10px;
}
.merchant_table a {
}
.merchant_table th {
	text-align:left;
	padding:7px 15px;
	background-color:#444;
	color:#fff;
	border: 1px solid #444;
	border-bottom: 0;
}
.merchant_table td {
	padding:7px 15px;
	border-left:1px solid #ddd;
}
.merchant_table_nocell th {
	text-align:left;
	padding:7px 5px 3px;
	vertical-align:top;
	min-width:90px;
}
.merchant_table_nocell td {
	padding:3px 5px;
}
.merchant_table_right {
	border-right:1px solid #ddd;
}
.merchant_table tr:nth-child(odd) {
}
.merchant_table tr:nth-child(even) {
 background:rgba(204, 204, 204, 0.25);
}
.merchant_results {
}
.merchant_results .results_left {
	float:left;
}
.merchant_results .results_right {
	float:right;
	text-align:right;
	padding-top:4px;
}
.merchant_results .results_right a {
	margin-left:0;
}*/

/* CART
----------------------------------------------------------------------------------------------------*/
.cart_block {

}
.cart_block h1 {
	border-bottom: 1px dotted #C5C5C5;
    color: #333333;
    font-size: 17px;
    margin: 0 0 10px;
    padding-bottom: 4px;
    text-transform: uppercase;
}
.cart_block ul {
}
.cart_block ul li {
	margin-bottom:5px;
}
.cart_table {
	border-bottom:1px solid #ddd;
	border-right:1px solid #ddd;
	width:100%;
	margin:10px 0 20px;
}
.cart_table a {
}
.cart_table th {
	text-align:left;
	padding:7px 15px;
	background-color:#444;
	color:#fff;
	border: 1px solid #444;
	border-bottom: 0;
}
.cart_table td {
	padding:7px 15px;
	border-left:1px solid #ddd;
}
.cart_table_nocell th {
	text-align:left;
	padding:7px 5px 3px;
	vertical-align:top;
	min-width:90px;
}
.cart_table_nocell td {
	padding:3px 5px;
}
.cart_table_right {
	border-right:1px solid #ddd;
}
.cart_table tr:nth-child(odd) {
}
.cart_table tr:nth-child(even) {
 background:rgba(204, 204, 204, 0.25);
}
.cart_results {
}
.cart_results .results_left {
	float:left;
}
.cart_results .results_right {
	float:right;
	text-align:right;
	padding-top:4px;
}
.cart_results .results_right a {
	margin-left:0;
}

/* SORTABLE AND DRAGGABLE
----------------------------------------------------------------------------------------------------*/
.ui-sortable-helper {
	background: rgba(255,255,255,0.85) !important;
	-webkit-box-shadow: 0px 0px 15px 5px rgba(0, 102, 255, .35) !important;
	   -moz-box-shadow: 0px 0px 15px 5px rgba(0, 102, 255, .35) !important;
			box-shadow: 0px 0px 15px 5px rgba(0, 102, 255, .35) !important;
}
.ui-sortable-space {
	background: #FFE7A3 !important;
}
.sortable_position {
	border-radius:3px;
    display: inline-block;
    height: 12px;
    line-height: 13px;
    padding: 5px;
    width: 12px;
}
.sortable_tip {
	color: #909090;
    font-size: 11px;
    font-style: italic;
    margin: 10px 0 0;
    background: url('../img/ico_note.png') no-repeat 0 1px transparent;
    padding-left:20px;
}

/* VENDORS
----------------------------------------------------------------------------------------------------*/
/* Addthis */
.addthis_default_style {
	display: inline-block;
}

/* Chosen */
.chzn-container {
	margin-bottom: 1rem !important;
	color: #202020;
}
.chzn-container-single .chzn-single {
	padding: 0.5rem !important;
	height: auto !important;
	line-height: normal !important;
	color: rgba(0, 0, 0, 0.75) !important;
	font-size: 0.8rem !important;
}
.chzn-container-single .chzn-single div b {
	background-position: 0px 8px !important;
}
.chzn-container-active.chzn-with-drop .chzn-single div b {
	background-position: -18px 8px !important;
}

/* jQuery UI */
.ui-datepicker td {
	background-color: #efefef;
}

/* DEBUG
----------------------------------------------------------------------------------------------------*/
#debug_box {
	width:960px;
	margin:1rem auto;
	font-size:0.85rem;
	font-family: 'Open Sans', 'Microsoft YaHei New', 'Microsoft Yahei', '微软雅黑', 宋体, SimSun, STXihei,'华文细黑', sans-serif;
	padding:1rem 1.67rem;
	border:3px solid #0066FF;
	border-radius:0.9rem;
	overflow:scroll;
}
#debug_box h1 {
	padding:0;
	margin:0 0 1rem;
	font-size:1.2rem;
}



