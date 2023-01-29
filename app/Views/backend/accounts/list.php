<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Backend Accounts List Page</title>
    </head>

    <body>
    
        {if !empty($system_message)}
            <label for="">{system_message}</label>
        {endif}

        <h1>Accounts List</h1>
        <a href="/backend/accounts/create">新增</a>
        <table>
            <thead>
                <th>ID</th>
                <th>帳號</th>
                <th>信箱</th>
                <th>操作</th>
            </thead>
            <tbody>
                {data}
                <tr>
                    <td>{ID}</td>
                    <td>{account_name}</td>
                    <td>{account_email}</td>
                    <td>
                        <a href="/backend/accounts/update/{ID}">編輯</a>
                        <form action="/backend/accounts/delete/{ID}" method="post">
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit">刪除</button>
                        </form>
                    </td>
                </tr>
                {/data}
            </tbody>
        </table>

        

    </body>

</html>