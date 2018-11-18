$(document).ready(() => {
    /***
     * DEFAULT INIT OF FIELDS
     */
    $('.modal').modal(); // bottom sheet
    M.updateTextFields(); // textfields
    $('select').formSelect(); // dropdown menu

    // save cottage form
    $('#save').click(() => {
        var cottage_name = $("#cottage_name").val()
        var place = $("#place").val()
        var contact_no = $("#contact_no").val()
        var price = $("#price").val()
        var category = $("#category").val()
        var available = $("#available").prop('checked')
        var fileNames = $("#file").val()
        var filenames2 = $("#mutlifile").val()

        var obj = {
            name:cottage_name,
            place:place,
            contact:contact_no,
            price:price,
            category:category,
            available:available,
            fileNames:fileNames,
            filenames2:filenames2
        }

        console.log(obj)
    })
});


/*
=========================
    COTTAGE
=========================
 */

// Cottage list api call and renders UI
const renderCottageList = () => {
    $.ajax({
        type : "GET",
        dataType: "json",
        url: "../api/cottage_list.php", 
        async :false, //chrome has problem with async response so it must be false
        success: (result) => {
            $('#cottageList').html(cottageListUI(JSON.stringify(result)))
        }
    });
}

// create cottage list UI 
const cottageListUI = (result) => {
    let { success, message, data } = JSON.parse(result)
    if(success == 1){
        return data.map((item,index) => {
            return `
                <div class="col s12 ${index % 2 == 0 ? "extra-light-primary-color" :""}">
                    <div class="row">
                        <div class="col s12 m6">
                            <h6 class="bold">${item.name}</h6>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">place</i>${item.place}</div>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">call</i>${item.contact}</div>
                        </div>
                        <div class="col s12 m4">
                            <h6 class="bold ${item.available == "1" ? "success-text-color" : "failure-text-color"}">${item.available == "1" ? "Available" : "Not Available"}</h6>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">star</i>${item.category}</div>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">account_balance_wallet</i>${item.price} <i class="tiny-font">/ day</i></div>
                        </div>
                        <div class="col s12 m2">
                            <p class="right-align">
                                <a id="blockBtn" class="waves-effect waves-light btn-small ${item.blocked == "1" ? "green darken-2" : "red darken-2"}">
                                    ${item.blocked == "1" ? "Unblock" : "Block"}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            `
        })
        
    }else{
        return `
            <div class="row center-align">
                <h6 class="secondary-text-color">${message}</h6>
            </div>
        `
    }

}

/*
=========================
    USERS
=========================
 */

// call user get api and render user list
const renderUserList = () => {
    $.ajax({
        type : "GET",
        dataType: "json",
        url: "../api/user_list.php", 
        async :false, //chrome has problem with async response so it must be false
        success: (result) => {
            $('#userList').html(userListUI(JSON.stringify(result)))
        }
    });
}

// create cottage list UI 
const userListUI = (result) => {
    let { success, message, data } = JSON.parse(result)
    if(success == 1){
        return data.map((item,index) => {
            return `
                <div class="col s12 ${index % 2 == 0 ? "extra-light-primary-color" :""}">
                    <div class="row">
                        <div class="col s12 m10">
                            <h6 class="bold">${item.firstname} ${item.lastname}</h6>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">mail</i>${item.email}</div>
                            <div class="secondary-text-color valign-wrapper center-align"><i class="material-icons tiny small-right-margin">call</i>${item.contact}</div>
                        </div>
                        <div class="col s12 m2">
                            <p class="right-align">
                                <a id="blockBtn" class="waves-effect waves-light btn-small ${item.blocked == "1" ? "green darken-2" : "red darken-2"}">
                                    ${item.blocked == "1" ? "Unblock" : "Block"}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            `
        })
        
    }else{
        return `
            <div class="row center-align">
                <h6 class="secondary-text-color">${message}</h6>
            </div>
        `
    }

}