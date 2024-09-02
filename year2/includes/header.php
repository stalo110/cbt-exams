<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Online Examination System</title>
    <link rel=stylesheet href="css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="fonts/awesome/css/font-awesome.css" />
    <link rel=stylesheet href="admin/css/styles.css" type="text/css" />
    <link rel=stylesheet href="admin/css/sty.css" type="text/css" />
    <script>
function addChar(input, character) {
if(input.value == null || input.value == "0")
input.value = character
else
input.value += character
}
function cos(form) {
form.display.value = Math.cos(form.display.value);
}
function sin(form) {
form.display.value = Math.sin(form.display.value);
}
function tan(form) {
form.display.value = Math.tan(form.display.value);
}
function sqrt(form) {
form.display.value = Math.sqrt(form.display.value);
}
function ln(form) {
form.display.value = Math.log(form.display.value);
}
function exp(form) {
form.display.value = Math.exp(form.display.value);
}
function deleteChar(input) {
input.value = input.value.substring(0, input.value.length - 1)
}
var val = 0.0;
function percent(input) {
val = input.value;
input.value = input.value + "%";
}
function changeSign(input) {
if(input.value.substring(0, 1) == "-")
input.value = input.value.substring(1, input.value.length)
else
input.value = "-" + input.value
}
function compute(form) {
form.display.value = eval(form.display.value);
}
function square(form) {
form.display.value = eval(form.display.value) * eval(form.display.value)
}
function checkNum(str) {
for (var i = 0; i < str.length; i++) {
var ch = str.charAt(i);
if (ch < "0" || ch > "9") {
if (ch != "/" && ch != "*" && ch != "+" && ch != "-" && ch != "."
&& ch != "(" && ch!= ")" && ch != "%") {
alert("invalid entry!")
return false
}
}
}
return true
}
</script>
</head>
<body>
    
    <div class="parent">
<div class="child">
<form name="sci-calc">
<table class="calculator" cellspacing="0" cellpadding="1">
<tr>
<td colspan="5"><input id="display" name="display" value="0" size="28" 

maxlength="25"></td>
</tr>
<tr>
<td><input type="button" class="btnTop" name="btnTop" value="C" 

onclick="this.form.display.value= 0 "></td>
<td><input type="button" class="btnTop" name="btnTop" value="&larr;" onclick="deleteChar

(this.form.display)"></td>
<td><input type="button" class="btnTop" name="btnTop" value="=" onclick="if(checkNum

(this.form.display.value)) { compute(this.form) }"></td>
<td><input type="button" class="btnOpps" name="btnOpps" value="&#960;" onclick="addChar

(this.form.display,'3.14159265359')"></td>
<td><input type="button" class="btnMath" name="btnMath" value="%" onclick=" percent

(this.form.display)"></td>
</tr>
<tr>
<td><input type="button" class="btnNum" name="btnNum" value="7" onclick="addChar

(this.form.display, '7')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="8" onclick="addChar

(this.form.display, '8')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="9" onclick="addChar

(this.form.display, '9')"></td>
<td><input type="button" class="btnOpps" name="btnOpps" value="x&#94;" onclick="if

(checkNum(this.form.display.value)) { exp(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="/" onclick="addChar

(this.form.display, '/')"></td>
<tr>
<td><input type="button" class="btnNum" name="btnNum" value="4" onclick="addChar

(this.form.display, '4')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="5" onclick="addChar

(this.form.display, '5')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="6" onclick="addChar

(this.form.display, '6')"></td>
<td><input type="button" class="btnOpps" name="btnOpps" value="ln" onclick="if(checkNum

(this.form.display.value)) { ln(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="*" onclick="addChar

(this.form.display, '*')"></td>
</tr>
<tr>
<td><input type="button" class="btnNum" name="btnNum" value="1" onclick="addChar

(this.form.display, '1')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="2" onclick="addChar

(this.form.display, '2')"></td>
<td><input type="button" class="btnNum" name="btnNum" value="3" onclick="addChar

(this.form.display, '3')"></td>
<td><input type="button" class="btnOpps" name="btnOpps" value="&radic;" onclick="if

(checkNum(this.form.display.value)) { sqrt(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="-" onclick="addChar

(this.form.display, '-')"></td>
</tr>
<tr>
<td><input type="button" class="btnMath" name="btnMath" value="&#177" 

onclick="changeSign(this.form.display)"></td>
<td><input type="button" class="btnNum" name="btnNum" value="0" onclick="addChar

(this.form.display, '0')"></td>
<td><input type="button" class="btnMath" name="btnMath" value="&#46;" onclick="addChar

(this.form.display, '&#46;')"></td>
<td><input type="button" class="btnOpps" name="btnOpps" value="x&#50;" onclick="if

(checkNum(this.form.display.value)) { square(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="+" onclick="addChar

(this.form.display, '+')"></td>
</tr>
<tr>
<td><input type="button" class="btnMath" name="btnMath" value="(" onclick="addChar

(this.form.display, '(')"></td>
<td><input type="button" class="btnMath" name="btnMath" value=")" onclick="addChar

(this.form.display,')')"></td>
<td><input type="button" class="btnMath" name="btnMath" value="cos" onclick="if

(checkNum(this.form.display.value)) { cos(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="sin" onclick="if

(checkNum(this.form.display.value)) { sin(this.form) }"></td>
<td><input type="button" class="btnMath" name="btnMath" value="tan" onclick="if

(checkNum(this.form.display.value)) { tan(this.form) }"></td>
</tr>
</table>
</form>
</div>

</div>
<header>


    <?php


    $query = "SELECT exam_time FROM courses WHERE id = $exam_id";
    $select_exam_query = mysqli_query($connection, $query);

        if(!$select_exam_query){
        die("QUERY FAILED". mysqli_error($connection));
    }

    while($row = mysqli_fetch_assoc($select_exam_query)) {

        $exam_time = $row['exam_time'];


        $exam_time = $exam_time * 60;

    }

    $class_id = getValue('class_id','students',$student_id);
    $student_class = getValue('name','class',$class_id);

    $query = "SELECT course_title, course_name FROM courses WHERE id = '{$exam_id}' LIMIT 1";
    $select_course_query = mysqli_query($connection, $query);

    if(!$select_exam_query){
        die("QUERY FAILED". mysqli_error($connection));
    }

    while($row = mysqli_fetch_assoc($select_course_query)) {

        $sub_title = $row['course_name'];


    }

    if(!isset($_SESSION['course_title'])){
        $_SESSION['course_title'] = $sub_title;
    }

    $date = date('h:i:s', time());

//    $start_time = $date + $exam_time;

//    $end_time = "11:00:00";


    $start_exam_time = toSeconds($start_time);

    $s_time = $start_exam_time + $exam_time;



//    $start_time = toSeconds($start_time);

//    $end_time = toSeconds($end_time);

    $remaining = $s_time - $current_time;


    ?>


    <nav class="navbar navbar-inverse navbar-fixed-top" style=" background:linear-gradient(180deg,#ba6f29,#bf5902) !important; border-bottom:2px solid brown; border-top:-1px solid brown;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="color:#fff; font-weight:bold;" href="#"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse"  >

                <ul class="nav navbar-nav navbar-right" style="color:green !Important;" >
                    <li style="font-weight: 800; font-size: 1.5em; border:2px solid transparent; background:linear-gradient(180deg,white,yellow); border-bottom-left-radius:20px; border-bottom-right-radius:20px; color:green !Important;"><a style="color:green !Important;"><i class="fa fa-clock-o" style="font-size:1.5em; color:#bf5902"></i> <span id="countdown" class="timer" style="color:green;"></span></a></li>

                </ul>
            </div><!--/.nav-collapse -->
        </div>

       <!-- <div class="info" style="background-color:#bf5902 !important;">
            <div class="container" style="background-color:#bf5902 !important;">
                <div class="row">

                    <div class="col-md-6">
                        <div class="container" style="background-color:#bf5902 !important;">
   
                  <h2><img style="height: 30px" src="images/logo3.png"><span style="font-family:Arial black; color: #fff; font-size:25px"> <?php echo $_SESSION['institution_name']; ?> <?php echo date('Y', time()) ?> Exam</span></h2>

                   <img style="margin: 10px 0px; float: right;" src="images/logo2.png">
                            <h3 class="white">Current Subject : <span class="text-capitalize"><?php echo $sub_title ?></span></h3>
                            <h3 class="white">Class : <?php echo $student_class ?></h3>

                        </div>
                    </div>-->
                    <div class="col-md-4 pull-right" style="display:flex; width:100%;">

<?php if($_SESSION['profile_pics'] == ""){ ?>
<img class="student-img img-circle" height="50" width="50" src="images/images.jpg">
<?php }else { ?>
<img class="student-img img-circle" height="50" width="50" src="images/<?php echo $_SESSION['profile_pics']; ?>">
<?php } ?>

              
                        <span style="font-size:1.5em; font-weight:800; display:inline-block;" class="white text-capitalize"> <?php echo $name ?> </span>
                        <div style="font-size:1.4em;" class="white">&nbsp;<?php echo $matric_no; ?> | <?php echo $student_class ?> | <span style="font-weight:bold;"><?php echo $sub_title ?></span></div>
                        <div class="calc"><a onclick="$('.parent').slideToggle('slow');return false">Pop calculator</a></div> 
                    </div>
                </div>
            </div>
        </div>
   
    </nav>


</header>
</body>
</html>
