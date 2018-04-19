<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $n_paciente
 * @property string $nombre
 * @property string $password
 *
 * @property Citas[] $citas
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['n_paciente', 'nombre'], 'required'],
            [['n_paciente'], 'string', 'max' => 5],
            [['nombre'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 64],
            [['n_paciente'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'n_paciente' => 'N Paciente',
            'nombre' => 'Nombre',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Citas::className(), ['usuario_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }
    /**
     * Este método valida la contraseña comparándola con la codificada en la BD.
     *
     * @param string $password La contraseña que se validará
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(
            $password, $this->password
        );
    }
}
