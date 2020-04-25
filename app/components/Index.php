<?php

    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Log;
    use App\Core\Router;
    use App\Models\PhoneModel;

    class Index extends AbstractController
    {
        private $phonemodel;

        public function __construct()
        {
            $this->phonemodel = new PhoneModel();
        }

        public function index()
        {
            $data['phones'] = $this->phonemodel->allPhone();
            $data['modal'] = Router::render('layouts/modal');

            return Router::render('main', $data);
        }

        public function PhoneAjax()
        {
            $response = NULL;
            try {
                if (!empty($_POST['second-name']) && !empty($_POST['phone-number'])) {
                    if (preg_match('@^[a-zA-Zа-яА-Я]*$@u', $_POST['second-name'])) {
                        if (preg_match('@^\+38\d{10}$@', $_POST['phone-number'])) {
                            if (isset($_POST['add'])) {
                                if ($this->phonemodel->uniquePhone()) {
                                    $response['new-phone'] = $this->phonemodel->addPhone();
                                    $response['message'] = 'Данные добавлены.';
                                    $response['status'] = true;
                                } else {
                                    $response['message'] = 'Введенный номер телефона уже записан.';
                                }
                            } elseif ($this->phonemodel->uniquePhone() || $this->phonemodel->anotherName()) {
                                $this->phonemodel->updatePhone();
                                $response['message'] = 'Данные изменены.';
                                $response['status'] = true;
                            } else {
                                $response['message'] = 'Введенные номер телефона или фамилия уже записаны.';
                            }
                        } else {
                            $response['message'] = 'Телефон неверного формата.<br/>Пример: +380000000000';
                        }
                    } else {
                        $response['message'] = 'В имени присутствуют не разрешенные символы.<br/>Можно использовать только русские и английские символы.';
                    }
                } else {
                    $response['message'] = 'Не все поля заполнены.';
                }
                echo json_encode($response);

            } catch (\Exception $e) {
                die(Log::writeLog($e->getMessage()));
            }
        }

        public function deletePhoneAjax()
        {
            $response = NULL;
            try {
                if (!empty($_POST['id'])) {
                    $this->phonemodel->deletePhone();
                    $response['message'] = 'Запись успешно удалена.';
                    $response['status'] = true;
                } else {
                    $response['message'] = 'Произошла непредвиденная ошибка, попробуйте ещё раз.';
                    throw new  \RuntimeException($response['message']);
                }
                echo json_encode($response);

            } catch (\RuntimeException $e) {
                die(Log::writeLog($e->getMessage()));
            }
        }

    }