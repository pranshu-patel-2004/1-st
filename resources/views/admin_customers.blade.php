<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>


    <!-- Logout Form -->

<div class="log-out">
    
        <h1>Welcome to the Admin Dashboard - Customer List</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
</div>

    <!-- Navigation -->
    <nav>
        <a href="{{ route('admin.dashboard') }}">View Products</a>
        <a href="{{ route('admin.customers') }}">View Customers</a>
    </nav>

    <br>
    <table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Added By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customerProducts as $customer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->country_name }}</td>
                <td>{{ $customer->state_name }}</td>
                <td>{{ $customer->city_name }}</td>
                <td>{{ $customer->added_by  }}<br>({{$customer->added_by_email}})</td>
                <td>
                    <span class="status {{ $customer->status == 'pending' ? 'pending' : 'approved' }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </td>
                <td>
                    @if($customer->status == 'pending')
                        <form action="{{ route('customer_products.approve', $customer->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Approve</button>
                        </form>
                    @else
                        <span>Approved</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>
