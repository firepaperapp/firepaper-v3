<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>chart-showcase.css" /> 
<title><?php echo ucfirst($this->Session->read("username")); ?></title>
<meta name="keywords" content="<?php if (isset($metaKeyword)){ echo $metaKeyword; } ?>" />
<meta name="description" content="<?php if (isset($metaDescription)) { echo $metaDescription; } ?>" />
<!--<link rel="stylesheet" href="<?php echo CSS_PATH;?>popupjquery/general.css" type="text/css" media="screen" />-->
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>ie8.css" type="text/css" media="screen" />

<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>ie7.css" type="text/css" media="screen" />

<![endif]-->

<script>
	var siteUrl = "<?php echo SITE_HTTP_URL;?>";	
	var siteImagesUrl = "<?php echo SITE_HTTP_URL;?>app/webroot/images/";
</script>
<!--<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.4.2.js"></script>-->
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>bubble.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>common.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-idleTimeout.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.knob.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo JS_PATH;?>morris.min.js"></script>
<script type="text/javascript">
        
$(document).ready(function(){
    var s = <?php echo Configure::read('Session.timeout');?>;
    $(document).idleTimeout({
      alive_url:'<?php echo SITE_HTTP_URL;?>users/check_user_login',
      logout_url:'<?php echo SITE_HTTP_URL;?>users/check_user_login',
      //redirect_url:'<?php echo SITE_HTTP_URL;?>dashboard'
    });
  });
  
     // Build jQuery Knobs
        $(".knob").knob();



        //  jQuery Flot Chart
        var visits = [[1, 50], [2, 40], [3, 45], [4, 23],[5, 55],[6, 65],[7, 61],[8, 70],[9, 65],[10, 75],[11, 57],[12, 59]];
        var visitors = [[1, 25], [2, 50], [3, 23], [4, 48],[5, 38],[6, 40],[7, 47],[8, 55],[9, 43],[10,50],[11,47],[12, 39]];

        var plot = $.plot($("#statsChart"),
            [ { data: visits, label: "Signups"},
             { data: visitors, label: "Visits" }], {
                series: {
                    lines: { show: true,
                            lineWidth: 1,
                            fill: true, 
                            fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.09 } ] }
                         },
                    points: { show: true, 
                             lineWidth: 2,
                             radius: 3
                         },
                    shadowSize: 0,
                    stack: true
                },
                grid: { hoverable: true, 
                       clickable: true, 
                       tickColor: "#f9f9f9",
                       borderWidth: 0
                    },
                legend: {
                        // show: false
                        labelBoxBorderColor: "#fff"
                    },  
                colors: ["#a7b5c5", "#30a0eb"],
                xaxis: {
                    ticks: [[1, "JAN"], [2, "FEB"], [3, "MAR"], [4,"APR"], [5,"MAY"], [6,"JUN"], 
                           [7,"JUL"], [8,"AUG"], [9,"SEP"], [10,"OCT"], [11,"NOV"], [12,"DEC"]],
                    font: {
                        size: 12,
                        family: "Open Sans, Arial",
                        variant: "small-caps",
                        color: "#9da3a9"
                    }
                },
                yaxis: {
                    ticks:3, 
                    tickDecimals: 0,
                    font: {size:12, color: "#9da3a9"}
                }
             });

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y - 30,
                left: x - 50,
                color: "#fff",
                padding: '2px 5px',
                'border-radius': '6px',
                'background-color': '#000',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#statsChart").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(0);

                    var month = item.series.xaxis.ticks[item.dataIndex].label;

                    showTooltip(item.pageX, item.pageY,
                                item.series.label + " of " + month + ": " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

</script>
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>


<section class="wrapper">
<?php echo $this->element("common/leftsidebar");?>
	<section class="container">
	<?php echo $this->element("common/header");?>
	<?php echo $content_for_layout; ?>
	
	</section>

	<?php echo $this->element("common/footer");?>	 

</section>
<div id="fancybox-overlay1" style="background-color: rgb(119, 119, 119);  position: absolute;top: 0;width: 100%;z-index: 1100;cursor: pointer; height: 1114px; opacity:0.7;display: none;"></div>
</body>
</html>
