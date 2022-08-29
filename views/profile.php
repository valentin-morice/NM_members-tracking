<?php

$this->render('views/partials/header.php');

?>

<?php

$entity = [];

foreach($_SESSION['members'] as $member) {
    if ($this->escape($this->id) == $member['info']['id']) {
        $entity['name'] = $member['info']['donor']['name'];
        $entity['id'] = $member['info']['id'];
        $entity['donor_id'] = $member['info']['donor_id'];
        $entity['status'] = $member['info']['status'];
        $entity['gateway'] = $member['info']['gateway'];
        $entity['recurring'] = $member['info']['recurring_amount'];
        $entity['date_created'] = $member['info']['donor']['date_created'];
        $entity['amount'] = $member['info']['recurring_amount'];
        $entity['currency'] = $member['info']['currency'];
        $entity['email'] = $member['info']['donor']['email'];
        if ($member['info']['donor']['address']) {
        $entity['address']['street'] = $member['info']['donor']['address']['billing'][0]['line1'];
        $entity['address']['zip'] = $member['info']['donor']['address']['billing'][0]['zip'];
        $entity['address']['city'] = $member['info']['donor']['address']['billing'][0]['city'];
        $entity['address']['country'] = $member['info']['donor']['address']['billing'][0]['country'];
        }
    }
}

$last_donation = [];

foreach($_SESSION['donations'] as $donation) {
    if ($entity['donor_id'] == $donation['payment_meta']['_give_payment_donor_id'] && $entity['recurring'] == $donation['total']) {
        $last_donation['status'] = $donation['status'];
        $last_donation['date'] = $donation['date'];
    }
}

echo "<b>Name: </b> " . $entity["name"] . "<br>";
echo "<b>Amount: </b> " . $entity["amount"] . " " . $entity["currency"] . "<br>";
echo "<b>Gateway: </b> " . ucfirst($entity["gateway"]) . "<br>";
echo "<b>Status: </b> " . ucfirst($entity["status"]) . "<br>";
echo "<b>Account Created: </b> " . date("d/m/Y", strtotime(substr($entity["date_created"], 0, 10))) . "<br>";
echo "<b>Email: </b> " . $entity["email"] . "<br>";
echo "<b>Address: </b>";
if (array_key_exists('address', $entity)) {
echo "<br>" . $entity["address"]["street"] . "<br>";
echo $entity["address"]["zip"] . ", " . $entity["address"]["city"] . "<br>";
echo $entity["address"]["country"] . "<br>";
} else {
    echo "No address recorded <br>";
}
echo "<b>Last Payment: </b> ";
if (array_key_exists('status', $last_donation)) {
    echo $last_donation["status"] . ", " . date("d/m/Y", strtotime(substr($last_donation['date'], 0, 10))) . "<br>";
} else {
    echo "<i>Cannot Retrieve</i><br>";
}


echo "<br><a href='/'>Back to Main</a>";

$this->render('views/partials/footer.php');
