<style>
  /* Styling h1 and links
––––––––––––––––––––––––––––––––– */
.starrating{
    direction: ltr
}
.starrating > input {display: none;}  /* Remove radio buttons */

.starrating > label:before { 
  color: #c59358;
  content: "\0047"; /* Star */
  font-size: 20px;
  margin: 2px;
  font-family: "visitiran";
  display: inline-block; 
}

.starrating > label
{
  font-family: "visitiran";
  display: inline-block; /* Start color when not clicked */
}
.starrating > input:active ~ label
{ color: #c59358 ;
content: "\0049";
font-family: "visitiran";
display: inline-block;  }
  .starrating > input:checked ~ label
{ color: #c59358 ;
content: "\0049";
font-family: "visitiran";
  display: inline-block;  } /* Set yellow color when star checked */

.starrating > input:hover ~ label
{ color: #c59358 ;
content: "\0049";
font-family: "visitiran";
  display: inline-block;  }
.starrating > input:checked ~ label::before
{ color: #c59358 ;
content: "\0049";
font-family: "visitiran";
  display: inline-block;  } /* Set yellow color when star hover */
.starrating > label:hover ~ label::before{
    color: #c59358 ;
    content: "\0049" !important;
    font-family: "visitiran";
}
.starrating > label:hover::before{
    color: #c59358 ;
    content: "\0049" !important;
    font-family: "visitiran";
}

</style>
<div id="comment-rate" class="container">
        <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
            <input onclick="setSelectedRate(5)" type="radio" id="star1" name="rating" value="5" /><label  for="star1" title="5 star"></label>
            <input onclick="setSelectedRate(4)" type="radio" id="star2" name="rating" value="4" /><label  for="star2" title="4 star"></label>
            <input onclick="setSelectedRate(3)" type="radio" id="star3" name="rating" value="3" /><label  for="star3" title="3 star"></label>
            <input onclick="setSelectedRate(2)" type="radio" id="star4" name="rating" value="2" /><label  for="star4" title="2 star"></label>
            <input onclick="setSelectedRate(1)" type="radio" id="star5" name="rating" value="1" /><label  for="star5" title="1 star"></label>
        </div>
  </div>	

  <script>
    function setSelectedRate(rate) {
      $("#comment-rate").attr('data-rate', rate);
    }
  </script>