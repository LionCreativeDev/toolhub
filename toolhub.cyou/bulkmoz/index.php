<!doctype html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="stylesheet/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="stylesheet/bootstrap.css">
        <link rel="stylesheet" href="stylesheet/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="stylesheet/buttons.dataTables.min.css">
		
        <style>
        /* width */
        ::-webkit-scrollbar {
        width: 6px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #f1f1f1; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #888; 
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #555; 
        }
        </style>
    </head>
<body style="background: #efecec;">
	<div class="container" style="padding: 10px 10px 10px 10px;background: #fff; margin-top:20px; margin-bottom:20px;">
		<div>
			<label style="display:block;">Multiple Url For Moz Metrices</label><label style="display:block;float:right;" class='totallines'>Total Urls: 0</label>
			<textarea id="txtLinks" style="width:100%; height: 100%; margin: auto auto;font-size: 14px;" rows=10></textarea>
			<br><br>
			<button type="submit" style="display:block;" class="btn btn-default btnCheckMoz">Check Moz</button>
		</div>		
	</div>
	
    <div class="container" id="result" style="padding: 10px 10px 10px 10px;background: #fff; display:none;">
        <div class="table-responsive">
            <table class="table" style="font-size:12px;">
    			<thead>
    				<tr>
    					<td> <font face="Arial">No</font> </td>
    					<td> <font face="Arial">Url</font> </td>
    					<td> <font face="Arial">Domain Authority</font> </td>
    					<td> <font face="Arial">Page Authority</font> </td>
    					<td> <font face="Arial">Moz Rank</font> </td>
    					<td> <font face="Arial">IP</font> </td>
    				</tr>
    			</thead>
    			<tbody>
    				<!--<tr>
    					<td><label class="no">1</label></td>
    					<td><label class="url">Multiple Url For Moz Metrices</label></td>
    					<td><label class="da">Multiple Url For Moz Metrices</label></td>
    					<td><label class="pa">Multiple Url For Moz Metrices</label></td>
    					<td><label class="mozrank">Multiple Url For Moz Metrices</label></td>
    				</tr>
    				<tr><td><label class="no"></label></td><td><label class="url"></label></td><td><label class="da"></label></td><td><label class="pa"></label></td><td><label class="mozrank"></label></td></tr>-->
				</tbody>
			</table>
        </div>
    </div>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="javascript/popper.min.js"></script>
    <script src="javascript/bootstrap.min.js"></script>
   
    <script type="text/javascript" src="javascript/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="javascript/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="javascript/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="javascript/buttons.flash.min.js"></script>
    <script type="text/javascript" src="javascript/jszip.min.js"></script>
    <script type="text/javascript" src="javascript/pdfmake.min.js"></script>
    <script type="text/javascript" src="javascript/vfs_fonts.js"></script>
    <script type="text/javascript" src="javascript/buttons.html5.min.js"></script>
    <script type="text/javascript" src="javascript/buttons.print.min.js"></script>

    <script type="text/javascript" language="javascript" >
        $(document).ready(function(){
			$(".btn-default").css({"background":"#007bff","border-color":"#007bff", "color":"white","padding":"5px 10px","font-size":"12px","margin-top":"-3px"});
			
			$(".btnCheckMoz").click(function(){
			    $('.table').DataTable().clear().destroy();
			    $(".table > tbody").empty();
                $("#result").hide();
				var links = $('#txtLinks').val().split('\n');
				//console.log('clicked '+links.length);
				if(links.length > 0)
				{
					for(var i = 0; i < links.length; i++){
						//code here using lines[i] which will give you each line
						if (links[i].replace(/^\s+|\s+$/, '').length != 0) {
							//OpenLink(links[i]);
							//console.log(links[i]);
							$('.table tbody').append('<tr class="nc"><td><label class="no">'+(i+1)+'</label></td><td><label class="url">'+links[i]+'</label></td><td><label class="da"></label></td><td><label class="pa"></label></td><td><label class="mozrank"></label></td><td><label class="ip"></label></td></tr>');
						}
					}
					$("#result").show();
					
					$('.table').DataTable({
						//"processing" : true,
						//"serverSide" : true,
						//"ajax" : {
						//    url:"fetch.php",
						//    type:"POST"
						//},
						"lengthMenu": [ [1000, 5000, 10000, 50000, -1], [1000, 5000, 10000, 50000, "All"] ],
						dom: 'Bfrtip',
						//buttons: [
						//    'pageLength', 'copy', 'csv', 'excel', 'pdf', 'print'
						//  ],
						buttons: [
							'pageLength',
							//'copy',
							//{
							//	extend: 'csvHtml5',
							//	title: 'All Scraped Results'
							//},
							{
								extend: 'excelHtml5',
								title: 'Bulk Moz Results'
							},
							// {
								// text: 'Export to GSheets',
								// action: function ( e, dt, button, config ) {
									// //var data = dt.buttons.exportData();
									// //exportToSheets(data);
									// exportToSheets();
								// }
							// },
							//{
							//	extend: 'pdfHtml5',
							//	title: 'All Scraped Results'
							//},
							//'print'
						]
					});

					$("button").css({"background":"#007bff","border-color":"#007bff", "color":"white","padding":"2px 10px","font-size":"10px"});
					
					// window.setInterval(function(){
						// if($(".nc").length > 0)
						// {
							// GetResults();
						// }
						// else
						// {
							// clearInterval();
						// }
					// }, 2000);
					GetResults();
				}
			});

			function GetResults(){
				$(".nc:lt(2)").each(function(){
					//console.log($(this).find('td').eq(1).text() + ':' + $(this).find('td').eq(2).text());
					//$(this).find('.progress-bar').css('width', '80%').attr('aria-valuenow', '80');
					var url = $(this).find("td").eq(1).text();
					var row = $(this);
					//console.log(url);
					
					$.ajax('BulkMoz.php?url='+url,
					{
						//dataType: 'json', // type of response data
						//timeout: 500,     // timeout milliseconds
						success: function (data,status,xhr) {   // success callback function
							try {
								//console.log(data);
								var objResult = JSON.parse(data);
								$(row).find('.da').text(objResult["DA"]);
								$(row).find('.pa').text(objResult["PA"]);
								$(row).find('.mozrank').text(objResult["MOZRANK"]);
								$(row).find('.ip').text(objResult["IP"]);
								
								$(row).attr('class', 'checked');
								
								setTimeout(function(){
								    $('.table').DataTable().destroy();
								    $('.table').DataTable({
                                        "lengthMenu": [ [1000, 5000, 10000, 50000, -1], [1000, 5000, 10000, 50000, "All"] ],
                                        dom: 'Bfrtip',
                                        buttons: [
                                            'pageLength',
                                            {
                                                extend: 'excelHtml5',
                                                title: 'Bulk Moz Results'
                                            },
                                        ]
                                    });
                                    $("button").css({"background":"#007bff","border-color":"#007bff", "color":"white","padding":"2px 10px","font-size":"10px"});
									GetResults();
								},1000);
							}
							catch(err) {
								console.log('exception: '+err.message);
							}
						},
						error: function (jqXhr, textStatus, errorMessage) { // error callback 
							//$('p').append('Error: ' + errorMessage);
							console.log(errorMessage);
							
							setTimeout(function(){
									GetResults();
							},1000);
						}
					});
					
					
					
					return false; // breaks
				})
			}
			
			$("#txtLinks").bind("paste", function(e){
				// access the clipboard using the api
				// var pastedData = e.originalEvent.clipboardData.getData('text');
				// alert(pastedData);
				setTimeout(function ()
				{
					//alert($("#txtLinks").val().split("\n").length);
					
					var links = $('#txtLinks').val().split('\n');
					//console.log('clicked '+links.length);
					if(links.length > 0)
					{
						$('.totallines').text("Total Urls: "+links.length);
					}
				},0);
			});
        });
    </script>

</body>
</html>