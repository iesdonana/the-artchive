<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    /**
     * Nombre.
     * @var string
     */
    public $name;
    /**
     * Email
     * @var string
     */
    public $email;
    /**
     * Asunto.
     * @var string
     */
    public $subject;
    /**
     * Cuerpo del mensaje.
     * @var string
     */
    public $body;
    /**
     * Código de verificación.
     * @var string
     */
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Nombre'),
            'verifyCode' => Yii::t('frontend', 'Código de verificación'),
            'subject' => Yii::t('frontend', 'Asunto'),
            'body' => Yii::t('frontend', 'Contenido'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
