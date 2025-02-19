<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="flexxiss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>
<?php include 'header.php'; ?>

    <div class="profile">
        <section>
            <div class="col-left">
                <div class="user-header">
                    <!-- User Info -->
                    <div class="user-info">
                        <h6 class="personalinfo">USER INFORMATION</h6>
                        
                        <!-- Button trigger modal -->
                        <button type="button" class="btn" id="ve" data-bs-toggle="modal" data-bs-target="#saveModal">
                                <i class="fa-regular fa-pen-to-square edit-icon"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="saveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-center align-items-center">
                                        <h1 class="modal-title fs-5" id="saveModal">VIEW & EDIT PET INFORMATION</h1>
                                    </div>
                                    <div class="modal-body">
                                    INSERT  FORM DATA OF PET
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center align-items-center" id="dfoot">
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut">Cancel</button>
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut" id="ccbut">Save Changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                    </div>
                    <!-- Notification Bell -->
                    <div class="notifBell">
                        <i class="fa-regular fa-bell notif-icon"></i>
                    </div>      
                </div>

                <div class="user-deets">
                    <div class="pfp">
                        <img src="profile_icon.png" alt="" class="profile-icon">
                        <h6 class="cusID">CUSTOMER ID</h6>
                        <h6 class="cusNum">NO. ######</h6>
                        <h6 class="cusMem">Regular</h6>
                    </div>

                    <div class="deets">
                        <div class="name">
                            <div class="deet1">
                                <p class="deet">FIRST NAME</p>                     
                                <hr class="hline">
                                <p class="deet">CONTACT NUMBER</p>
                                <hr class="hline">
                            </div>
                            <div class="deet2">
                                <p class="deet">LAST NAME</p>                        
                                <hr class="hline">
                                <p class="deet">CONTACT NUMBER</p>
                                <hr class="hline">
                            </div>
                        </div>
                        
                        <div class="deet3">
                            <p class="deet">ADDRESS</p>                        
                            <hr class="hline">
                            <p class="deet">SOCIAL LINK</p>
                            <hr class="hline">
                        </div>
                    </div>
                </div>

                <div class="user-transactions">
                    <div class="user-current">
                        <table class="curr">
                            <thead class="cRev">
                                <th class="currRev">CURRENT RESERVATIONS</th>
                            </thead>
                            <tbody >
                                <tr>
                                    <td class="crBody">
                                        <div class="tDeets">
                                            <h6 class="tStatus">Ongoing</h6>

                                            <div class="tDeets1">
                                                <div class="tDeets1-1">
                                                    <p class="tpetname">DOG NAME</p>
                                                </div>

                                                <div class="tDeets1-2">
                                                    <p class="price">Php 0000.00</p>
                                                </div>
                                            </div>

                                            <div class="tDeets2">
                                            <div class="tDeets2-1">
                                                    <p class="tservice">Pet Hotel</p>
                                                    <p class="tId">Transaction ID NO </p>
                                                    <p class="tDate">October </p>

                                                </div>

                                                <div class="tDeets2-2">
                                                    <div class="reqtoCancel-but">
                                                        <button class="btn" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Request to Cancel</button>
                                                            <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Are you sure you want to cancel?</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    We're sorry to see you go! Please confirm if you'd like to cancel your booking. 
                                                                    If you need assistance, feel free to reach out to us.
                                                                    
                                                                    <ul class="radio-checklist" >
                                                                        <li><input type="radio" name="reason" id="ChangeOfPlans"> Change of Plans</li>
                                                                        <li><input type="radio" name="reason" id="PersonalEmergency"> Personal Emergecy</li>
                                                                        <li><input type="radio" name="reason" id="SchedulingConflict"> Scheduling Conflict</li>
                                                                        <li><input type="radio" name="reason" id="DissatisfactionWithServices"> Dissatisfaction with Services</li>
                                                                        <div class="reason4">
                                                                            <li><input type="radio" name="reason" id="Others"> Other Specify: </li>
                                                                                <textarea class="form-control" id="message-text"></textarea>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center align-items-center">
                                                                    <button class="btn" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" id="ccbut">Proceed to Cancel</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Your Cancellation is Being Processed</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    We’re processing your refund now. Kindly wait a moment, and we’ll notify you once it's complete. 
                                                                    Thank you for your patience!</div>
                                                                <div class="modal-footer d-flex justify-content-center align-items-center">
                                                                    <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut">Confirm</button>
                                                                    <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut" id="ccbut">Cancel</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                    

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                   <div class="user-history">
                        <table class="hist">

                            <thead class="hRev">
                                <th class="currRev">RESERVATIONS HISTORY</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="rhBody">
                                    <h6 class="tStatus">Ongoing</h6>
                                    <p class="tpetname">DOG NAME</p> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>

            <div class="col-right">
                <h6 class="pbi"> PET INFORMATION</h6>
                

                <div class="petDeets">
                    <div class="petImg">
                        <img src="pet_icon.png" alt="" class="pet-icon">
                    </div>
                    <div class="petInfo">
                        <p class="petname">DOG NAME</p> 
                        <p class="petdesc">Sex, Breed, Age</p>
                        <div class="actions">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn" id="ve" data-bs-toggle="modal" data-bs-target="#saveModal">
                                <p class="view-and-edit">View & Edit</p>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="saveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-center align-items-center">
                                        <h1 class="modal-title fs-5" id="saveModal">VIEW & EDIT PET INFORMATION</h1>
                                    </div>
                                    <div class="modal-body">
                                    INSERT  FORM DATA OF PET
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center align-items-center" id="dfoot">
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut">Cancel</button>
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut" id="ccbut">Save Changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn" id="delbut"  data-bs-toggle="modal" data-bs-target="#delModal">
                                <p class="del">Delete</p>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-center align-items-center" id="dhead">
                                        <h1 class="modal-title text-center" id="del-head">Are you sure?</h1>
                                    </div>
                                    <div class="modal-body d-flex justify-content-center align-items-center" id="dbody">
                                        <h6 class="modal-title text-center" id="del-body">
                                            Deleting this file will remove all records of your pet from our system permanently.
                                        </h6>
                                    
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center align-items-center" id="dfoot">
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut">Confirm</button>
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="ccbut" id="ccbut">Cancel</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                        </div>

                    </div>
                </div>
                
                <div class="rPet">
                    <h6 class="regPet">Need to register new pet?</h6>
                </div>       
            </div>
        </section>
    </div>
</body>
</html>