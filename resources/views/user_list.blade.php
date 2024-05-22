<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body class="container">
    <div class="alert alert-primary" role="alert" id="alert" style="display:none;">
        A simple primary alert—check it out!
      </div>
      
    <form id="create-form">
        @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">description</label>
          <input type="text" class="form-control" id="detail" name="detail">
        </div>

        <button type="button" id="btnAdd" class="btn btn-primary">Submit</button>
      </form>


      <script>

       // JavaScript
                $(document).ready(function() {

                    $('#btnAdd').click(function() {

                        var formData = $('#create-form').serialize();

                        var headers = {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        };

                        $.ajax({
                            type: 'POST',
                            url: '/create',
                            data: formData,
                            headers: headers,
                            success: function(response) {

                                console.log(response.success);

                                
                                $.ajax({
                                type: 'POST',
                                url: '/notif',
                                data: {description: response.success},
                                headers: headers,
                                success: function(resp) {

                                    $('#alert').show(); 

                                    // Inserted notification ID
                                    console.log('Notification ID:', resp.notification_id);
                             
                                    
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }

                                });

                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });


                });

      </script>

</body>
</html>

