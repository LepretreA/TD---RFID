<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    body{
  background-color: #ccc;
}
.clear {
    clear: both;
}
p {
    font-size: 5px;
    margin: 2px;
}
.id-card-holder {
    width: 450px;
    margin: 0 auto;
	font-family:'verdana';
}
.id-card {
    /* background-color: #3fcdd5; */
    padding: 0px;
    text-align: center;
    box-shadow: 0 0 1.5px 0px #b9b9b9;
    display: block;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(to bottom, #3fcdd5 0%, #dce3e8 100%);
}
.header {
    padding: 10px;
    background-color: #3fcdd5;
}
.header img {
    width: 100px;
    margin-top: 0px;
    display: inline;
    float: left;
}
.id {
    display: inline-block;
    float: left;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    text-align: center;
    margin-left: 60px;
}
.b-border {
    height: 2px;
    display: block;
    background-color: #3fcdd5;
    margin-top: 1px;
}
.card-detail {
    width: 100%;
    display: block;
    padding: 10px;
    box-sizing: border-box;
}
.stu-photo {
    float: left;
    width: 100px;
}
.stu-photo img {
    width: 100%;
    border: 1px solid #4a0a2c;
    border-radius: 5px;
}
.stu-info {
    float: left;
    width: calc(100% - 100px);
    padding: 0 10px;
    box-sizing: border-box;
    text-align: left;
    text-transform: capitalize;
}
.stu-info h3 {
    font-size: 15px;
    margin: 0 0 10px 0;
    padding: 5px 15px;
    background-color: #4a0a2c9e;
    border-radius: 70px;
    text-align: center;
    color: #fff;
    border: 1px solid #4a0a2cfc;
}
.stu-info p {
    font-size: 12px;
    margin: 0 0 3px 0;
    font-weight: 300;
}
.stu-info p span {
    font-weight: 600;
    text-transform: uppercase;
}
footer {
    padding: 5px 0;
    border-top: 1px solid #000;
}
footer p {
    font-size: 7px;
    margin: 0 0 2px 0;
}
</style>
<body>
	
	<div class="id-card-holder">
		<div class="id-card">
			<div class="header">
				<img src="https://file.diplomeo-static.com/file/00/00/01/46/14675.svg">
        
<!-- 				<img src="https://assets.codepen.io/3243230/internal/avatars/users/default.png?fit=crop&format=auto&height=80&version=1577268632&width=80"> -->
        
        <p class="id">Carte scolaire 2023-2024</p>
        <div class="clear"></div>
      </div>
      <span class="b-border"></span>
      
      <div class="card-detail">
        <div class="stu-photo">
<!--           <img src="http://peoplehelp.in/mewaruni/images/student.jpg" alt="student image"/> -->
          <img src="http://192.168.65.237/TP3-HUGO/TP3/new/photo/3EDD8299.jpg" alt="no-picture" >
        </div>
        <div class="stu-info">
          <h3>Étudiant n° : <span> 3EDD8299</span></h3>
          <p>Nom : <span> Tiennot</span></p>
          <p>Prénom :<span> Thibaut</span></p>
          <p>Né le : <span> 03/10/2003</span></p>
          <p><span>EXT</span><span style="padding-left: 150px;" >BTSSN2</span></p>
        </div>
        
        <div class="clear"></div>
      </div>
      
      <footer>
			<p><strong>Lycée Professionnel la Providence Amiens </strong> <p>
			<p>146 bd Saint-Quentin, 80094 AMIENS cedex 3</p>
			<p>Tel: 03 22 33 77 77 | E-mail: contact@la-providence.net</p>
			<p>Copryrights © Tout droits réservés avec © www.la-providence.net</p>
      </footer>
		</div>
	</div>
	
</body>
</html> 
</body>
</html>