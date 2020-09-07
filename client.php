
<html>
	<head>
		<title>Sample small API for Kulcs-Soft</title>
		<style type="text/css">
			body{
				text-align: center;
			}
			#container{
				width: 200px;
				position:absolute;
				top:50px;
				left:50%;
				margin-left:-100px;
			}
			div{
				margin-top: 10px;
			}
			select{
				width: 90%;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<h2>API Form POST</h2>
			<form method="POST" action="api/user">
				<div>
					<label for="Action">Action:</label>
					<select name="Action" id="Action">
						<option value="GET">Get</option>
						<option value="DELETE">Delete</option>
					</select>
				</div>
				<div>
					<label for="userId">UserId:</label>
					<input type="number" name="userId" id="userId" placeholder="userId"/> 
				</div>
				<div>
					<input type="hidden" name="apiKey" id="apiKey" placeholder="apiKey" value="e3ecc8f0-6d44-4fd1-ad4d-0ee0817e2027" readonly="readonly"/> 
				</div>
				<div>
					<label for="datatype">Datatype:</label>
					<select name="datatype" id="datatype">
						<option value="XML">XML</option>
						<option value="JSON">JSON</option>
					</select>
				</div>
				<div>
					<input type="submit" value="Send" name="btn"/> 
				</div>
			</form>
		</div>
	</body>
</html>