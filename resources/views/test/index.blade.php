<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Form</title>
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
                <h1 class="mb-4">Profile Form</h1>
                <form id="profileForm">
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
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="text" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter your Location">
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
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- New rows will be appended here -->
                </tbody>
            </table>
        </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        fetchProfiles();
        // Handle form submission
        function fetchProfiles() {
            $.ajax({
                url: "{{ route('test.view') }}",
                type: "GET",
                success: function(data) {
                    let rows = '';
                    data.forEach(function(profile) {
                        rows += `<tr>
                                    <td>${profile.name}</td>
                                    <td>${profile.email}</td>
                                    <td>${profile.phone}</td>
                                    <td>${profile.address}</td>
                                  </tr>`;
                    });
                    $('#profileTable tbody').html(rows);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
           





        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
    
            let formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                _token: '{{ csrf_token() }}'
            };
    
            $.ajax({
                url: "{{ route('test.store') }}",    
                type: "POST",
                data: formData,
                success: function(response) {
    
                    // Add the new data to the table
                    let newRow = `<tr>
                                    <td>${formData.name}</td>
                                    <td>${formData.email}</td>
                                    <td>${formData.phone}</td>
                                    <td>${formData.address}</td>
                                  </tr>`;
                    $('#profileTable tbody').append(newRow);
    
                    // Reset the form
                    $('#profileForm')[0].reset();
                },
                error: function(xhr) {
                    alert('Something went wrong!');
                    console.error(xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>
