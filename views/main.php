<h1>NM Membership Tracking</h1>
<p>Sort by clicking on table headers &#127773;</p>
<?php 

echo "<table><thead class='tablehead'><tr><th>id</th><th>Name</th><th>Email</th><th>Amount</th><th>Cur</th><th>Gateway</th><th>Status</th><th>Card</th></tr></thead><tbody>";
foreach($_SESSION['members'] as $member) {
    echo "<tr><td>" . $member['info']['id'] . "</td><td>" . $member['info']['donor']['name'] . "</td><td>" . $member['info']['donor']['email'] . "</td><td>" . $member['info']['recurring_amount'] . "</td><td>" . $member['info']['currency'] . "</td><td>" . ucwords($member['info']['gateway']) . "</td><td>" . ucwords($member['info']['status']) . "</td>";
    echo '<td><form target="_blank" action="/members/card" method="post"><input name="id" id="id" hidden type="text" value="';
    echo $member['info']['id'] . '"><button id="submit" name="submit" value="submit">Generate Card</button></form>';
}

echo "</table>";

?>

<style>

body {
    font-family: sans-serif;
}

table {
  table-layout: fixed;
  width: 100%;
  border-collapse: collapse;
  border: 3px solid #ECCCB2;
  overflow: scroll;
}

table button {
    margin-bottom: -15px;
}

thead th:nth-child(1) {
  width: 5%;
}

tr:nth-child(even) {
    background-color: #F5E8C7;
}

tr:nth-child(odd) {
    background-color: #F7F6DC;
}

thead th:nth-child(2) {
  width: 15%;
}

thead th:nth-child(3) {
  width: 20%;
}

thead th:nth-child(4) {
  width: 5%;
}

thead th:nth-child(5) {
  width: 5%;
}

thead th:nth-child(6) {
  width: 8%;
}

thead th:nth-child(7) {
  width: 8%;
}

thead th:nth-child(8) {
  width: 8%;
}

th, td {
  padding: 20px;
  text-align: left
}

.tablehead tr {
    background-color: #ECCCB2; 
    cursor: pointer;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
   $('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
</script>
 

