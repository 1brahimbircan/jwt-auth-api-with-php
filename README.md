
## API Kullanımı

### Kullanıcı Kaydet

```http
  POST /api/v1/register-user
```

| Parametre  | Tip      | Açıklama                                             |
| :--------- | :------- | :--------------------------------------------------- |
| `name`     | `string` | **Gerekli**. Kaydedilecek kullanıcının ismi          |
| `email`    | `string` | **Gerekli**. Kaydedilecek kullanıcının eposta adresi |
| `password` | `string` | **Gerekli**. Kaydedilecek kullanıcının şifresi       |

Request:
```json
{
  "name":"deneme",
  "email":"deneme@gmail.com",
  "password":"123456"
}
```
Response:
```json
{
    "status": 1,
    "message": "User has been registered successfully",
    "user": {
        "userId":"3091842t9102348911231..." 
        "name": "deneme",
        "email": "deneme@gmail.com"
    },
    "token": "eyJhbGdvIjoiSFMyNTYiLCJ0eXBlIjo..."
}
```

### Kullanıcı Girişi

```http
  POST /api/v1/login-user
```

| Parametre | Tip     | Açıklama                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | **Gerekli**. Giriş yapacak kullanıcının eposta adresi |
| `password`      | `string` | **Gerekli**. Giriş yapacak kullanıcının şifresi |

Request:
```json
{
  "email":"deneme@gmail.com",
  "password":"123456"
}
```
Response:
```json
{
    "status": 1,
    "message": "User logged in successfully",
    "user": {
        "userId":"3091842t9102348911231..." 
        "name": "deneme",
        "email": "deneme@gmail.com"
    },
    "token": "eyJhbGdvIjoiSFMyNTYiLCJ0eXBlIjo..."
}
```

### Kullanıcı Getirme

```http
  GET /api/v1/get-user
```

| Parametre | Tip     | Açıklama                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`      | `Bearer Token` | **Gerekli**. Giriş yapacak kullanıcının tokeni |


Request:
```json
Authorization: User JWT
```
Response:
```json
{
    "status": 1,
    "message": "Get User successfully",
    "user": {
        "userId":"3091842t9102348911231..." 
        "name": "deneme",
        "email": "deneme@gmail.com"
    },
    "token": "eyJhbGdvIjoiSFMyNTYiLCJ0eXBlIjo..."
}
```

### Kullanıcı Güncelleme ( DÜZELTİLDİ !! )
* ~~NOT: En yakın zamanda düzeltilecektir.~~

```http
  PATCH /api/v1/update-user
```

| Parametre       | Tip            | Açıklama                                       |
| :-------------- | :------------- | :--------------------------------------------- |
| `Authorization` | `Bearer Token` | **Gerekli**. Giriş yapacak kullanıcının tokeni |
| `name`          | `String`       | **Gerekli**. Kullanıcının yeni ismi            |
| `email`         | `String`       | **Gerekli**. Kullanıcının yeni eposta adresi   |
| `password`      | `String`       | **Gerekli**. Kullanıcının yeni şifresi         |


Request:
```json
Authorization: User JWT
{
  "name":"deneme123",
  "email":"deneme1@gmail.com",
  "password":"1234567"
}
```
Response:
```json
{
    "status": 1,
    "message": "User update successful"
}
```
### Kullanıcı Silme ( DÜZELTİLDİ !! )
* ~~NOT: En yakın zamanda düzeltilecektir.~~

```http
  DELETE /api/v1/delete-user
```

| Parametre | Tip     | Açıklama                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`      | `Bearer Token` | **Gerekli**. Giriş yapacak kullanıcının tokeni |


Request:
```json
Authorization: User JWT
```
Response:
```json
{
    "status": 1,
    "message": "User delete successful"
}
```


  