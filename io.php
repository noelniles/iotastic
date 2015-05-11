<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>I/Otastic</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div class="container">
<div class="row">
    <h2 class="page-header">Welcome to I/Otastic <small>write you some stuff...</small></h2>

    <form class="">
    <div class="col-md-6">
        <input type="text" class="form-control" id="title-input" name="title-input" placeholder="Eye Catching Title">
        <textarea type="text" class="form-control" id="iotastic-editor" name="iotastic-editor" rows="20"></textarea>
        <button class="btn" id="iotastic-editor-submit" type="submit" name="iotastic-editor-submit">Submit</button>
    </div><!-- End iotastic-textarea -->
    </form>

    <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">preview</h3>
        <div id="iotastic-alert-panel"></div>
      </div>
      <div class="panel-body" id="iotastic-viewer" name="iotastic-viewer" rows="100">
      </div>
    <button class="btn" id="preview-new-page" type="submit" name="preview-new-page">Open in new page</button>
    </div>
    </div><!-- End iotastic-preview -->

</div><!-- End row -->
</div><!-- End container -->
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    var editor = '#iotastic-editor';
    var viewer = '#iotastic-viewer';
    var alertPanel = '#iotastic-alert-panel';

    $('#preview-new-page').on('click', function(event) {
        var html_data = $('#iotastic-viewer').html();
        var title = $('#title-input').val();
        var snd_data = {
            "html": html_data,
            "title": title
        };
        $.post('src/preview-new-page.php', snd_data, function(data) {
            var resp = $.parseJSON(data);
            if (resp.success) {
                $(alertPanel).addClass('alert alert-success');
                $(alertPanel).html('<p>file saved as '+resp.save_as_name+'</p>');       
                window.open('http://localhost/exp/iotastic/src/pages/'+resp.title, 'iotasticPreviewTab', 'target=_blank');
            } else {
                $(alertPanel).addClass('alert alert-warning');
                $(alertPanel).html('<p>There was a problem saving the file.</p>');       
            }

        }); 
    });

    $('form').submit(function(event) {
        $.post('src/iotastic-editor-action.php', $(this).serialize(), function(data) {
            $(viewer).html(data);
            console.log(data); 
        });
        event.preventDefault();
    });
</script>
</html>
