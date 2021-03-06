$(document).ready(() => {
    /***
     * DEFAULT INIT OF FIELDS
     */
    $('.modal').modal(); // bottom sheet
    M.updateTextFields(); // textfields
    $('select').formSelect(); // dropdown menu

    // save cottage form
    $('#save').click(() => {
        $('#addForm').submit();
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
                                <a id="blockBtnCottage" class="waves-effect waves-light btn-small ${item.blocked == "1" ? "green darken-2" : "red darken-2"}" onclick="toggleCottageBlock(${item.id},${item.blocked})">
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

// block unblock cottage
const toggleCottageBlock = (id,newStatus) => {
    let postData = {
        cottage_id:id,
        block_status:newStatus == 1 ? 0 : 1
    }
    $.ajax({
        type : "POST",
        dataType: "json",
        url: "../api/block_cottage.php", 
        data:JSON.stringify(postData),
        async :false, //chrome has problem with async response so it must be false
        contentType: "application/json; charset=utf-8",
        success: (result) => {
            M.toast({html: result.message, classes: 'rounded',displayLength:1000})
            renderCottageList()
        }
    });
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
                                <a id="blockBtnUser" class="waves-effect waves-light btn-small ${item.blocked == "1" ? "green darken-2" : "red darken-2"}" onclick="toggleUserBlock(${item.id},${item.blocked})">
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

// block unblock user
const toggleUserBlock = (id,newStatus) => {
    let postData = {
        user_id:id,
        block_status:newStatus == 1 ? 0 : 1
    }
    $.ajax({
        type : "POST",
        dataType: "json",
        url: "../api/block_user.php", 
        data:JSON.stringify(postData),
        async :false, //chrome has problem with async response so it must be false
        contentType: "application/json; charset=utf-8",
        success: (result) => {
            M.toast({html: result.message, classes: 'rounded',displayLength:1000})
            renderUserList()
        }
    });
}


