<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Polling</title>
<style>
*{
	margin: 0;
	padding: 0;
}
body{
	font-size: 16px;
	font-family: Arial, sans-serif;
}
.container{
	width: 1170px;
	max-width: 90%;
	margin: auto;
}
.login_page{
	min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.form_wrapper{
	display: flex;
    align-items: center;
    justify-content: center;
}
.form_wrapper form .input_box label{
	display: inline-flex;
	flex-direction: column;
}
.form_wrapper form .input_box label span{

}
.heading{
	font-size: 25px;
    font-weight: 600;
    padding: 0 0 15px;
    font-family: serif;
}
.form_error{
	color: red;
	font-size: 14px;
}
.input_box{
	padding: 0 0 20px;
}
.input_box input{
	width: 300px;
	max-width: 90%;
	/*height: 30px;*/
	padding: 5px;
}
.input_box label{
	font-weight: 500;
}
</style>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>