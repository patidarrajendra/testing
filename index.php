<?php include("connection.php");?>
<html>

<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Hanalei+Fill|Indie+Flower|Kavivanar|Mr+Bedfort|Risque|Sedgwick+Ave" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/signature_pad.js"></script>

</head>

<body>
    <div class="row col-md-12">
        <div class="col-md-10">
            <div class="wrapper" style="position: relative;">
                <?php
                        $que="select * from upload_document where user_id='1'";
                        $query=mysqli_query($conn,$que);
                        if(mysqli_num_rows($query)>0)
                        {
                            $row=mysqli_fetch_array($query);
                            $id=$row['document_id'];
                            $que1="select * from document_signature_image where document_id='$id' ";
                            $query1=mysqli_query($conn,$que1);
                            if(mysqli_num_rows($query1)>0)
                            {
                                $i=1;
                                while($row1=mysqli_fetch_array($query1))
                                {
                                    $signature_id=$row1['signature_id'];
                                    $type=$row1['type'];
                                    $signature_image=$row1['signature_image'];
                                    $signature_coor=explode(",",$row1['postion']);
                                    $x_value=$signature_coor[0];
                                    $y_value=$signature_coor[1];
                                    if($type=='type')
                                    {

                                        $text_css=explode(",",$row1['text_css']);
                                        $x_css=$text_css[0];
                                        $y_css=$text_css[1];
                                        ?>
                                        <input type="hidden" name="signature_id[]" id="signature_id<?php echo $i;?>" value="<?php echo $signature_id;?>">
                                        <div id="draggable_<?php echo $i;?>" class="ui-widget-content update_section" style="background-color: #CDE9D4;top: <?php echo $y_value;?>px;left: <?php echo $x_value;?>px;">
                                            <h2 style="font-family: '<?php echo $x_css;?>', <?php echo $y_css;?>;font-size: 20px;padding-left: 18px;">
                                                <?php echo $signature_image;?>
                                            </h2>
                                        </div>
                            <?php }else if($type=='draw' || $type=='upload'){?>

                                        <input type="hidden" name="signature_id[]" id="signature_id<?php echo $i;?>" value="<?php echo $signature_id;?>">
                                        <div id="draggable_<?php echo $i;?>" class="ui-widget-content update_section" style="background-color: #CDE9D4;top: <?php echo $y_value;?>px;left: <?php echo $x_value;?>px;">
                                            <img src="<?php echo $signature_image;?>" style="height: 70px;width: 100px;" />
                                        </div>
                            <?php   }
                                        $i++;
                                    }}
                                ?>
                                        <div id="draggable" class="ui-widget-content" style="display: none;background-color: #F8EBC8;top: 342px;left: 624px;" onclick="show_modal()"></div>
                                        <img id="img1" src="<?php echo $row['ducument_name'];?>" style="height: 1000px;width: 1000px;" />
                            
                            <?php }else{ echo "Document not found";}?>

            </div>
        </div>
        <div class="col-md-2">
            <h1>Signature Platform</h1>
            <button class="btn btn-default" onclick="get_drop_box()">Draw Signature</button>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center>Signature</center></h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs action_tabs">
                        <li class="active"><a href="#draw" onclick="get_type('draw')">Draw</a></li>
                        <li><a href="#type" onclick="get_type('type')">Type</a></li>
                        <li><a href="#upload" onclick="get_type('upload')">Upload</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="draw" class="tab-pane fade in active">
                            <div class="wrapper">
                                <canvas id="signature-pad" class="signature-pad" width="400" height="100"></canvas>
                            </div>
                            <div>
                                <ul class="global-color">
                                    <li>
                                        <h4>Choose Color</h4>
                                    </li>
                                    <li class="yellow-pick" data-color="#f8c90d">Yellow</li>
                                    <li class="green-pick"  data-color="#3dae49">Green</li>
                                    <li class="orange-pick" data-color="#e87425">Orange</li>
                                    <li class="blue-pick"   data-color="#009cc5">Blue</li>
                                    <li class="black-pick on" data-color="#000000">Black</li>
                                </ul>
                            </div>
                        </div>
                        <div id="type" class="tab-pane fade">
                            <div class="wrapper1">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="font_text_name" id="font_text_name" class="form-control" onkeyup="get_font_apply(this.value)" style="margin-top: 15px;">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)" onclick="get_font_select('Mr Bedfort','cursive','box_size1')">
                                            <div class="box_size" id="box_size1">
                                                <h2 id="box1" style="font-family: 'Mr Bedfort', cursive;"></h2>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)" onclick="get_font_select('Risque','cursive','box_size2')">
                                            <div class="box_size" id="box_size2">
                                                <h2 id="box2" style="font-family: 'Risque', cursive;"></h2>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div style="margin-top: 120px;">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <a href="javascript:void(0)" onclick="get_font_select('Kavivanar','cursive','box_size3')">
                                                <div class="box_size" id="box_size3">
                                                    <h2 id="box3" style="font-family: 'Kavivanar', cursive;"></h2>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="javascript:void(0)" onclick="get_font_select('Hanalei Fill','cursive','box_size4')">
                                                <div class="box_size" id="box_size4">
                                                    <h2 id="box4" style="font-family: 'Hanalei Fill', cursive;"></h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div style="margin-top: 120px;">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <a href="javascript:void(0)" onclick="get_font_select('Sedgwick Ave','cursive','box_size5')">
                                                <div class="box_size" id="box_size5">
                                                    <h2 id="box5" style="font-family: 'Sedgwick Ave', cursive;"></h2>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="javascript:void(0)" onclick="get_font_select('Indie Flower','cursive','box_size6')">
                                                <div class="box_size" id="box_size6">
                                                    <h2 id="box6" style="font-family: 'Indie Flower', cursive;"></h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="upload" class="tab-pane fade">
                            <div class="wrapper">
                                <form id="image_upload" enctype="multipart/form-data" style="margin-top: 38px;">
                                    <input type="file" name="sign_file" id="file" class="form-control" style="margin-left: 50px;">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="sign_type" value="draw" name="">
                    <button type="button" onclick="clear_signature()" class="btn btn-primary">Clear</button>
                    <button type="button" onclick="save_signature();" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>

    <script type="text/javascript">
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        var x_cordinate      = "";
        var y_cordinate      = "";
        var glo_select1_css  = "";
        var glo_select2_css  = "";
        var glo_select2_text = "";


        function get_type(str) {
            $('#sign_type').val(str);
        }

        $(document).ready(function() {
            $(".nav-tabs a").click(function() {
                $(this).tab('show');
            });

            $(".update_section").draggable();

            $("#draggable").draggable();

            $('.global-color li').click(function() {
                $('.on').removeClass('on');
                var $t = $(this);
                $t.addClass('on');
                var selectedColor = $t.data('color');
                signaturePad.penColor = hexToRgb(selectedColor);
                setCurrentColor(canvas, selectedColor);
            });
        });



        $(".update_section").bind('dragstop', function() {
            var id_value = $(this).attr('id');
            var exp = id_value.split("_");
            var sig_id = $("#signature_id" + exp[1]).val();
            var x = $("#" + id_value).position();
            x_cordinate = x.left;
            y_cordinate = x.top;
            var operation = "update";
            $.ajax({
                url: "index1.php",
                cache: false,
                method: 'POST',
                data: {
                    'x_value': x_cordinate,
                    'y_value': y_cordinate,
                    'operation': operation,
                    'sig_id': sig_id
                },
                success: function(html) {
                    //location.reload();
                }
            });
        });

        function hexToRgb(hex) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? "rgb(" + parseInt(result[1], 16) +
                "," + parseInt(result[2], 16) +
                "," + parseInt(result[3], 16) + ")" :
                null;
        }

        function setCurrentColor(canvas, color) {
            var context = canvas.getContext('2d');
            context.save();
            context.fillStyle = color;
            context.globalCompositeOperation = 'source-in';
            context.fillRect(0, 0, canvas.width, canvas.height);
            context.restore();
        }

        function get_font_select(select1_css, select2_css, id_name) {
            var sign_txt = $("#font_text_name").val();
            glo_select1_css = select1_css;
            glo_select2_css = select2_css;
            glo_select2_text = sign_txt;
            $("#" + id_name).removeClass("box_size");
            $("#" + id_name).addClass("box_size1");
        }

        function get_font_apply(val) {
            $("#box1").html(val);
            $("#box2").html(val);
            $("#box3").html(val);
            $("#box4").html(val);
            $("#box5").html(val);
            $("#box6").html(val);
        }

        function get_drop_box() {
            $('#draggable').show();
        }

        function show_modal() {
            var x = $("#draggable").position();
            x_cordinate = x.left;
            y_cordinate = x.top;
            $('#myModal').modal('toggle');
        }

        function save_signature() {
            sign_type = $('#sign_type').val();
            if (sign_type == "draw") {
                var data = signaturePad.toDataURL('image/png');
                //console.log(data);
                var image = $("<img>", {
                    "src": data,
                    "width": "400px",
                    "height": "200px"
                });
                var operation = "insert";
                $.ajax({
                    url: "index1.php",
                    cache: false,
                    method: 'POST',
                    data: {
                        'data': data,
                        'x_value': x_cordinate,
                        'y_value': y_cordinate,
                        'operation': operation,
                        'sign_type': sign_type
                    },
                    success: function(html) {
                        $('#myModal').modal('toggle');
                        //location.reload();
                    }
                });
            } else if (sign_type == "upload") {
                var name = document.getElementById("file").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("file").files[0]);
                var f = document.getElementById("file").files[0];
                var fsize = f.size || f.fileSize;
                if (fsize > 2000000) {
                    alert("Image File Size is very big");
                } else {
                    form_data.append("file", document.getElementById('file').files[0]);
                    form_data.append('x_value', x_cordinate);
                    form_data.append('y_value', y_cordinate);
                    form_data.append('operation', 'insert');
                    form_data.append('sign_type', sign_type);
                    $.ajax({
                        url: 'index1.php',
                        type: 'post',
                        data: form_data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#myModal').modal('toggle');
                            //location.reload();
                        },
                    });

                }
            } else if (sign_type == "type") {
                var operation = "insert";
                $.ajax({
                    url: "index1.php",
                    cache: false,
                    method: 'POST',
                    data: {
                        'x_value': x_cordinate,
                        'y_value': y_cordinate,
                        'glo_select1_css': glo_select1_css,
                        'glo_select2_css': glo_select2_css,
                        'glo_select2_text': glo_select2_text,
                        'operation': operation,
                        'sign_type': sign_type
                    },
                    success: function(html) {
                        $('#myModal').modal('toggle');
                        //location.reload();
                    }
                });
            }
        }

        function clear_signature() {
            signaturePad.clear();
            $('#font_text_name').val('');
            get_font_apply('');
            $('#image_upload')[0].reset();
        }
    </script>
</footer>

</html>