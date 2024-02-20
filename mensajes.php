<html>
    <head>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Enmanuel Lassis">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">        
    </head>
    <body>
        <style>
            <?php include 'customCss.css'; ?>
        </style>
        <?php if($thrownMessage){?>
                <?php if(!strpos($thrownMessage, 'correctamente')){?>
                    <div id="errorDiv">
                        <?php 
                            echo $thrownMessage;
                        ?>
                    </div>                    
                <?php } else {?>
                    <div id="successDiv">
                        <?php 
                            echo $thrownMessage;
                        ?>
                    </div>
                <?php } ?>
        <?php } ?>
    </body>
</html>