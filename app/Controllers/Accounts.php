<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accounts extends BaseController
{

    private $validationRules = [
        'account_name' => [
            'label' => '系統帳號',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} 為必填'
            ]
        ],
        'account_email' => [
            'label' => '電子信箱',
            'rules' => 'required|valid_emails',
            'errors' => [
                'required' => '{field} 為必填',
                'valid_emails' => '請輸入正確的信箱格式'
            ]
        ],
    ];

    public function list()
    {

        $model = model(AccountsModel::class);

        $datas = [
            'system_message' => session('system_message'),
            'data' => $model->getAccounts(),
        ];

        $parser = \Config\Services::parser();

        return $parser->setData($datas)->render('/backend/accounts/list');

    }

    public function create()
    {
        //CSRF
        !empty(session()->getFlashdata('error')) ? $csrfError = "CSRF驗證失敗!" : $csrfError = "";

        if (!$this->request->is('post')) { //表單顯示

            $parser = \Config\Services::parser();

            // $parser->setData([
            //     'csrf_token' => csrf_token(),
            //     'csrf_hash' => csrf_hash(),
            //     'csrf_error' => $csrfError,
            //     'account_name' => old('account_name'),
            //     'account_email' => old('account_email'),
            //     'system_message' => session('system_message'),
            // ]);

            $data = [
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
                'csrf_error' => $csrfError,
                'action' => 'create',
                'ID' => '',
                'account_name' => old('account_name'),
                'account_email' => old('account_email'),
                'system_message' => session('system_message'),
            ];

            $parser->setData($data);

            // print_a($data);die();
            
            return $parser->render('/backend/accounts/edit');            

        } else { //資料儲存

            $parser = \Config\Services::parser();

            $inputData = $this->request->getPostGet(); //抓post進來的form資料

            if (!$this->validateData($inputData, $this->validationRules)) { //開始驗證

                foreach ($this->validator->getErrors() as $errorField => $errorMsg) { //驗證錯誤資訊陣列整理
                    $errorsArr[] = ['field' => $errorField, 'msg' => $errorMsg];
                }

                // print_a($inputData);die();;
                
                return redirect()->back()->withInput()->with('system_message',$errorsArr); //跳回新增頁

            }

            $inputData['account_pwd'] = password_hash($inputData['account_pwd'], PASSWORD_DEFAULT);

            $model = model(AccountsModel::class);

            $chk = $model->save($inputData);

            if ($chk) {
                $system_message = "新增成功";
            } else {
                $system_message = "新增失敗";
            }

            return redirect()->to('/backend/accounts')->with('system_message',$system_message);

        }

    }

    public function update($id)
    {
        //CSRF
        !empty(session()->getFlashdata('error')) ? $csrfError = "CSRF驗證失敗!" : $csrfError = "";

        $model = model(AccountsModel::class);

        if (!$this->request->is('put')) { //表單顯示
            
            $parser = \Config\Services::parser();
            
            $data = $model->getAccounts($id);

            $data['action'] = 'update';
            $data['csrf_token'] = csrf_token();
            $data['csrf_hash'] = csrf_hash();
            $data['csrf_error'] = $csrfError;
            $data['system_message'] = session('system_message');

            $parser->setData($data);

            // print_a($data);die();
            
            return $parser->render('/backend/accounts/edit');            

        } else { //資料儲存

            $parser = \Config\Services::parser();

            $inputData = $this->request->getPostGet(); //抓post進來的form資料

            // print_a($inputData);die();

            if (!$this->validateData($inputData, $this->validationRules)) { //開始驗證

                foreach ($this->validator->getErrors() as $errorField => $errorMsg) { //驗證錯誤資訊陣列整理
                    $errorsArr[] = ['field' => $errorField, 'msg' => $errorMsg];
                }

                return redirect()->back()->withInput()->with('system_message',$errorsArr); //跳回新增頁

            }

            $inputData['account_pwd'] = password_hash($inputData['account_pwd'], PASSWORD_DEFAULT);

            $chk = $model->save($inputData);

            if ($chk) {
                $system_message = "編輯成功";
            } else {
                $system_message = "編輯失敗";
            }

            return redirect()->to('/backend/accounts')->with('system_message',$system_message);

        }
    }

    public function delete($id)
    {

        $model = model(AccountsModel::class);

        $chk = $model->delete($id);

        if ($chk) {
            $system_message = "刪除成功";
        } else {
            $system_message = "刪除失敗";
        }

        return redirect()->to('/backend/accounts')->with('system_message',$system_message);

    }

}

?>