<!DOCTYPE html>
<html>
<head>
    <title>Customer Products</title>
    <link rel="stylesheet" href="{{ asset('css/b.css') }}">
</head>
<body>
    <div class="container mt-5">

        <!-- Logout Form -->
        <div class="log-out">
            <h1>Welcome to the User Dashboard</h1>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
        
      
        @if(session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="message error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Add Customer Button -->
        <button class="add-btn" onclick="showPopup()">Add Customer</button> 👈 Press This Too Add Customer


         <!-- Popup Form for Adding Customer -->
    <div id="customerPopup" class="popup">
        <div class="popup-content">
          
            
            <h2>Add Customer Detail</h2>

            <form method="POST" action="{{ route('customer_products.store') }}">
                @csrf
                <label>Name:</label>
                <input type="text" name="name" placeholder="Enter A Name" required><br></br>

                <label>Email:</label>
                <input type="email" name="email" placeholder="Enter A Email" required><br><br>

                <label>Phone:</label>
                <input type="text" name="phone" placeholder="Enter A Phone Number" required><br><br>

                <label>Address:</label>
                <textarea name="address" placeholder="Enter A Address" required></textarea><br><br>

                <label>Country:</label>
                <select name="country_id" id="country" required onchange="loadStates(this.value)">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select><br><br>

                <label>State:</label>
                <select name="state_id" id="state" required onchange="loadCities(this.value)">
                    <option value="">Select State</option>
                </select><br><br>

                <label>City:</label>
                <select name="city_id" id="city" required>
                    <option value="">Select City</option>
                </select><br><br>

                <label>Password:</label>
                <input type="password" name="password" placeholder="Enter A Password" required><br><br>

                <button type="submit">Save</button>
                <button type="button" onclick="closePopup()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- this is customere list -->
        <h2>Customers List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
               @if($customerProducts->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;">No customers are there.</td>
                </tr>
                @else
                @foreach($customerProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->email }}</td>
                        <td>{{ $product->phone }}</td>
                        <td>{{ $product->address }}</td>
                        <td>{{ $product->country_name }}</td>
                        <td>{{ $product->state_name }}</td>
                        <td>{{ $product->city_name }}</td>
                        <td>
                            <span class="status {{ $product->status == 'pending' ? 'status-pending' : 'status-approved' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>