<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="log-out">
    
    <h1>Welcome to the Admin Dashboard - Products List</h1>
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
    

    <!-- Product List -->
   
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Tags</th>
                <th>Image</th>
                <th>Variants</th>
                <th>Added By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->tags }}</td>
                    <td>
                        @if ($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" width="100">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @foreach ($product->variants as $variant)
                            <p>{{ $variant->variant }} - Quantity: {{ $variant->quantity }} - Price: Rs{{ $variant->price }}</p>
                        @endforeach
                    </td>
                    <td>
                    @if ($product->customer)
                        {{ $product->customer->name }}<br>
                         ({{ $product->customer->email }})
                    @else
                        Unknown
                    @endif
                </td>
                    <td>
                        <form action="{{ route('products.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
