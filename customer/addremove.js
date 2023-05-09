
function addquantity() {
  // var count = 0;
  var count = document.getElementById("quantity-data").value;
  alert(count);
}
 
// this function for storing data in session for temporart
function addcart(p_id, quantity) {
  var product_id = p_id;
  var quantity = quantity;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText); // replace 'this.responseText' with the actual response text from the server
    }
  };
  xmlhttp.open(
    "GET",
    "insertremove.php?action=addcart&quantity=" +
      quantity +
      "&id=" +
      product_id,
    true
  );
  xmlhttp.send();
}

function addwishlist(p_id) {
  var product_id = p_id;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText); // replace 'this.responseText' with the actual response text from the server
    }
  };
  xmlhttp.open(
    "GET",
    "insertremove.php?action=addwishlist&id=" + product_id,
    true
  );
  xmlhttp.send();
}

// this function is used for storing in database


function addtocart(p_id, quantity) {
  var product_id = p_id;
  var quantity = quantity;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText); // replace 'this.responseText' with the actual response text from the server
    }
  };
  xmlhttp.open(
    "GET",
    "addremovedb.php?action=addcart&quantity=" +
      quantity +
      "&id=" +
      product_id,
    true
  );
  xmlhttp.send();
}

function addtowishlist(p_id) {
  var product_id = p_id;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText); // replace 'this.responseText' with the actual response text from the server
    }
  };
  xmlhttp.open(
    "GET",
    "addremovedb.php?action=addwishlist&id=" + product_id,
    true
  );
  xmlhttp.send();
}

