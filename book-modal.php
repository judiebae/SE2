<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOR COPY PASTE PURPOSES</title>
    
    <style>
    .checkbox-container {
      display: flex;
      flex-direction: column; /* Stack checkbox and text */
      align-items: start;
    }

    #waiverForm-title{
      font-weight: bold;
      color: #AB643C;
      font-size: 200%
    }

    #waiverForm-header{
      border-bottom: none;
      background-image: url('waiverForm-paw-top.png'); /* Ensure the correct path */
      background-repeat: no-repeat;  /* Prevents the image from repeating */
      background-position: right bottom;
      background-size: auto 200%;  
    }

    #waiverForm-body{
      color: #421D11;
      padding: 2%;
    }

    #waiverForm-body hr{
      border: solid 1px #421D11;
    }
    #waiverForm-checkbox{
      font-weight: bold;
      margin-top: 10px;
      accent-color: #421D11;
      border: solid 2px #421D11;
    }

    #waiverForm-footer {
    border-top: none;
    background-image: url('waiverForm-paw-bottom.png'); /* Ensure the correct path */
    background-repeat: no-repeat;  /* Prevents the image from repeating */
    background-position: left top;
    background-size: auto 100%;  
    }

    #complete-booking{
      color: #fff;
      background-color: #421D11;
      border-radius: 5px;
      max-width: 100%;
      width: 20%
    }

    #complete-booking:hover{
      background-color:#AB643C;
      border-radius: 5px;
    }




    </style>
    
</head>
<body>

<?php include 'header.php'?>
    <!-- Button trigger modal -->
<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#waiverForm">
  Launch static backdrop modal
</button>

<!-- Modal -->  
<div class="modal fade" id="waiverForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" id="waiverForm-header">
        <h1 class="modal-title" id="waiverForm-title">Liability Release and Waiver Form</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="waiverForm-body">

        <p>
            We care about the safety and wellbeing of all pets. We want to assure you that we will make every effort to make your pet’s stay with us as pleasant as possible. 
            While we provide the best care for your fur babies, there are possible risks that come with availing of pet boarding services.
        </p>

      <ul>
        <!-- <h6> Health & Vaccination Requirements</h6> -->
        <li>
            Owner represents that his/her pet is in all respects healthy and received all required vaccines (Distemper/ Canine Adenovirus-2, Canine Parvovirus-2 and Rabies), currently flea protection (Frontline, Advantage or Revolution for dogs) and that said pet does not suffer from any disability, illness or condition which could affect the said paid, other pets, employees and customers safety. 
            If the Owner's pet has external parasites, Owner agrees by signing this form that ADORAFUR HAPPY STAY may apply frontline spray to Owner's pet at Owner's own cost, for such parasites so as not to contaminate this facility or the other pets saying at ADORAFUR HAPPY STAY.
        </li>

        <!-- <h6> Risk and Responsibilities</h6> -->
        <li>
            I recognize that there are inherent risks of injury or illness in any environment associated with cageless pets in daycare and in boarding environments. 
            I also recognize that such risks may include, without limitation, injuries or illnesses resulting from fights, rough play and contagious diseases. 
            Knowing such inherent risks and dangers, I understand and affirm that ADORAFUR HAPPY STAY cannot be held responsible for any injury, illness or damage caused by my pet and that I am solely responsible for the same. 
            I agree to hold ADORAFUR HAPPY STAY free and harmless from any claims for damage, all defense costs, fees and business losses arising from any claim or any third party may have against ADORAFUR HAPPY STAY.
        </li>

        <!-- <h6>Aggressive Pets Pollicy</h6> -->
        <li>
            Pets must be sociable to be allowed to stay with us.
            Some pets may have aggressive tendencies if triggered, despite being able to socialize. 
            If your pet has any history of aggression such as food, territorial, possessive aggression, or if they don't want to be touched in a certain body part, please inform us so we may cater to their behavior needs. 
            As much as possible we would love to avoid using restricting instruments to pets. However, if the need arise we may isolate, crate, leash or muzzle an aggressive pet. 
            In any case, we reserve the right to refuse any pet that are hostile, aggressive and appear to be ill for everyone's safety. 
        </li>

        <!-- <h6>Emergency Vet Care</h6> -->
        <li>
            Please be aware that we strive to avoid any accidents during their stay. 
            Pets can be unpredictable and injuries, illness or escaping may occur. 
            Minor injuries from nicks from clippers during grooming or rough play may result if your pet does not respond to the handler to behave properly during their stay. 
            All pet owners are required to accept these and other risks as a condition of their pet's participation in our services at Adorafur Happy Stay.
        </li>

        <!-- <h6>Ownership & Liability</h6> -->
        <li>
            Adorafur Happy Stay will not be held responsible for any sickness, injury or death caused by the pet to itself during grooming, 
            from pre-existing health conditions, natural disasters, or any illness a pet acquires due to non-vaccination or expired vaccines.   
        </li>

        <!-- <h6>Non-Payment & Abandonment Policy</h6> -->
        <li>
            I agree to hold Adorafur Happy Stay harmless from any claims for damage, all defense costs, fees and business losses arising resulting from any claims to be made against Adorafur Happy Stay 
            for which its agents or employees are not ultimately held to be legally responsible.
        </li>

        <!-- <h6>Owner Responsibilities</h6> -->
        <li> I certify that my pet has never unduly harmed or threatened anyone or any other pets.</li>
        <li> I expressly agree to be held responsible for any damage to property (i.e. kennels, fencing, walls, flooring etc.) caused by my pet.</li>
        <li> I expressly agree to be held responsible for medical costs for any human injury caused by my pet. </li>

        <!-- <h6>Pet Health & Medical Disclosures</h6> -->
        <li>The Owner understands that it is possible for us to discover a pet's illness during their stay with us such as arthritis, cysts, 
          cancer or any health problems old age brings for senior dogs.</li>

            These conditions take time to develop and could be discovered during their stay. 
            In that case, we will notify you immediately if something feels off with your pet and we would take them to the vet to get a diagnosis and proper treatment, 
            costs shall be shouldered by the owner. We understand how stressful and worrisome this is if this may happen to your pet. 
            Rest assured we will give them the care they need and provide the best comfort for them as much as possible. We will send you daily updates, vet's advice and etc.

        <li>
            Your pet’s safety and well being is our absolute #1 priority.
        </li>

        <li>
            Should the owner leave intentionally their pet in ADORAFUR HAPPY STAY without giving any communication for more than 1 week, 
            ADORAFUR HAPPY STAY reserves the right to hold the pet as a security for non-payment of the services and may sell and alienate the same, 
            without the consent of the owner, to a third party to satisfy any claims it may have against the customer. 
            Otherwise, Adorafur Happy Stay shall have the dogs/ cats adopted or endorse them to the necessary dog impounding station as deemed necessary
        </li>

      </ul>

      Adorafur Happy Stay holds the highest standards to ensure that your pet is handled with respect and cared for properly. 
      It is extremely important to us that you know when your pet is under our supervision, Adorafur Happy Stay will provide them with the best care we can provide, 
      meeting the high expectations that we personally have for our own pets when under the supervision of another person. 
      We recognize and respect that all pets are living beings who have feelings and experience emotion. We value that you have entrusted your pet to us to provide our services to them.

        <hr>

<strong>Conforme: </strong>

    <p>
    By submitting this agreement form, I, the Owner, acknowledge represent that I have made full disclosure and have read, understand and accept the terms and conditions stated in this agreement. 
    I acknowledge all of the statements above and understand and agree to release Adorafur Happy Stay and its employees from any and all liabilities, expenses, and costs (including veterinary and legal fees) 
    resulting from any service provided, or unintentional injury to my pet while under their care or afterwards. I acknowledge this agreement shall be effective and binding on both parties. 
    I also agree to follow the health and safety protocols of Adorafur Happy Stay.
    </p>

    <p>
    <input type="checkbox" id="waiverForm-checkbox" name="agree" value="1" required>
    I hereby grant Adorafur Happy Stay  and its care takers permission to board and care for my pet
    </p>
    <p>
    <input type="checkbox" id="waiverForm-checkbox" name="agree" value="1" required>
    I have read and agree with the  Liability Release and Waiver Form
    </p>
</div>



      <div class="modal-footer" id="waiverForm-footer">
        <button type="button" class="btn" id="complete-booking">Complete Booking</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>