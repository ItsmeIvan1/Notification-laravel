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
        <h6 id="notif"></h6>
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
        <a href="{{ route('/history') }}">Go to Alert logs</a>
      </form>


      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Details</th>
            <th scope="col">TimeStamp</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($list as $user)
          <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->detail}}</td>
            <td>{{$user->created_at}}</td>
            <td>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="edit-btn" data-bs-target="#exampleModal"  data-user-id="{{ $user->id }}">Edit</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </td>
         
          </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="">
                    @csrf
                    <input type="hidden" id="Editid" />
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Name</label>
                      <input type="text" class="form-control" id="Editname" name="Editname" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">description</label>
                      <input type="text" class="form-control" id="Editdetail" name="Editdetail">
                    </div>
            
                    <button type="button" id="btnUpdate" class="btn btn-primary">Edit</button>
    
                  </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>

      <script>

       // JavaScript
                $(document).ready(function() {

                    var headers = {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        };

                    $('#btnAdd').click(function() {

                        var formData = $('#create-form').serialize();

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
                                    $('#notif').html( response.success);
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



                   $(document).on('click', '#edit-btn', function(){

                        var userId = $(this).data('user-id');

                        $.ajax({
                                type: 'GET',
                                url: '/edit-user/' + userId,
                                headers: headers,
                                success: function(resp) {

                                    $('#Editid').val(resp.id);
                                    $('#Editname').val(resp.name);
                                    $('#Editdetail').val(resp.detail);
                                    
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }

                                });
                            
                   })


                   $('#btnUpdate').click(function(){

                        var id = $('#Editid').val();
                        
                        var Editname = $('#Editname').val();
                        var Editdetail = $('#Editdetail').val();

                        $.ajax({
                                type: 'PUT',
                                url: '/update-user/' + id,
                                headers: headers,
                                data: {name: Editname,
                                       detail: Editdetail
                                },
                                success: function(resp) {

                                    if(resp.status == 'TRUE')
                                    {   
                                        $('#exampleModal').modal('hide');
                                        console.log(resp.message);

                                        $.ajax({
                                        type: 'POST',
                                        url: '/notif',
                                        data: {description: 'Successfully updated ' + resp.data.name || resp.data.detail},
                                        headers: headers,
                                        success: function(response) {

                                           

                                            $('#alert').show(); 
                                            $('#notif').html( resp.message +''+ resp.data.name || resp.data.detail);
                               
                                            console.log('Notification ID:', response.notification_id);
                                    
                                            
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(error);
                                        }

                                        });

                                    }


                                    
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }

                                });

                   })


                });

      </script>

</body>
</html>

