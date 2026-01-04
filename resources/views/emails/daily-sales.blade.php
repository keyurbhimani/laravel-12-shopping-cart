<p>Dear Admin, </p>
<h3>Daily Sales Report for {{ $date }}</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Product Name</th>
        <th>Total Sold</th>
        <th>Price</th>
        <th>Revenue</th>
    </tr>
    @foreach($sales as $sale)
        <tr>            
            <td>{{ $sale->name }}</td>
            <td>{{ $sale->total_sold }}</td>
            <td>${{ $sale->price }}</td>
            <td>${{ $sale->total_sold * $sale->price }}</td>
        </tr>    
    @endforeach
    <tr>
        <td colspan="3"><strong>Total Revenue</strong></td>
        <td><strong>${{ $sales->sum(fn($sale) => $sale->total_sold * $sale->price) }}</strong></td>
    </tr>
</table>
<p>Regards,</p>
<p>Your E-commerce Team</p>