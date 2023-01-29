<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Backend Accounts Edit Page</title>
    </head>

    <body>
        
        {if is_array($system_message) && count($system_message) > 0}
            <div class="error_area"> 
                {system_message}
                    <p>{msg}</p><br>
                {/system_message}
            </div>
        {endif}

        {if !empty($csrf_error) }
            <div class="csrf_error">
                <p>{csrf_error}</p><br>
            </div>
        {endif}
        

        <h1>Accounts Edit</h1>

        <form action="/backend/accounts/{action}/{ID}" method="post">

            <input type="text" name="account_name" id="account_name" value="{account_name}">
            <input type="password" name="account_pwd" id="account_pwd" value="">
            <input type="email" name="account_email" id="account_email" value="{account_email}">

            <input type="hidden" name="ID" value="{ID}">
            <input type="hidden" name="{csrf_token}" value="{csrf_hash}">
            {if $action == 'update'}
                <input type="hidden" name="_method" value="put">
            {endif}
            <button type="submit">Submit</button>

        </form>
        
    </body>

</html>