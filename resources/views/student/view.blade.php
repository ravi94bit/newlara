<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #dec8c8;
            font-family: Arial, sans-serif;
            color: #333;
        }
        h1 {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
       <!-- First Form -->
       <div class="d-flex justify-content-center " >
            <div class="bg-light text-center p-5 shadow rounded">
                <h1 class="mb-4">Student Form</h1>
                <form id="studentForm">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" class="form-control" name="class" id="class" placeholder="Enter your class">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                   
                </form>
            </div>
        </div>

        <div class="mt-5">
            <h2 class="text-center mb-4">Submitted Profiles</h2>
            <table class="table table-bordered table-striped" id="profileTable">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Class</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody id='profileTableBody2'>
                    
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            studentProfile();
    
            function studentProfile(){
                $.ajax({
                    url: "{{ route('student.view') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data){
                        var rows = '';
                        $.each(data, function(index, student){
                            rows += `<tr>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.class}</td>
                                <td>${student.phone}</td>
                            </tr>`;
                        });
                        $("#profileTableBody2").html(rows);
                    },
                    error: function(xhr){
                        alert("Something went wrong!");
                        console.error(xhr.responseText);
                    }
                });
            }
    
            $("#studentForm").on("submit", function(event){
                event.preventDefault();
                var formData = $(this).serialize();
    
                $.ajax({
                    url: "{{ route('student.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response){
                        var newRow = `<tr>
                            <td>${response.name}</td>
                            <td>${response.email}</td>
                            <td>${response.class}</td>
                            <td>${response.phone}</td>
                        </tr>`;
                        $("#profileTableBody2").append(newRow);
                        $("#studentForm")[0].reset(); // Reset the form
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                        console.error(xhr.responseText);
                    }
                });
            });
    
        });
    </script>
    
    
</body>
</html>