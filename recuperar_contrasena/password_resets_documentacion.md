# Documentación de la tabla password_resets

## Estructura de la tabla

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT AUTO_INCREMENT | Identificador único y clave primaria |
| email | VARCHAR(250) | Correo electrónico del usuario |
| token | VARCHAR(32) | Token generado aleatoriamente |
| expiry | DATETIME | Fecha y hora de caducidad del token |
| created_at | TIMESTAMP | Fecha y hora de creación (automático) |
| updated_at | TIMESTAMP | Fecha y hora de actualización (automático) |

## Instrucciones SQL

### Crear la tabla

```sql
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250) NOT NULL,
    token VARCHAR(32) NOT NULL,
    expiry DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX password_reset_email_index (email)
);
```

### Flujo de trabajo para restablecer contraseñas

1. **Generar y almacenar token**

```sql
INSERT INTO password_resets (email, token, expiry) 
VALUES ('usuario@ejemplo.com', 'abc123...', DATE_ADD(NOW(), INTERVAL 1 HOUR));
```

2. **Verificar un token**

```sql
SELECT * FROM password_resets 
WHERE email = 'usuario@ejemplo.com' 
  AND token = 'abc123...' 
  AND expiry > NOW();
```

3. **Eliminar token después de usarlo**

```sql
DELETE FROM password_resets 
WHERE email = 'usuario@ejemplo.com' 
  AND token = 'abc123...';
```

4. **Eliminar tokens expirados (mantenimiento)**

```sql
DELETE FROM password_resets WHERE expiry < NOW();
```

## Implementación en PHP

### Generar token y guardar en la base de datos

```php
function createPasswordReset($email, $connection) {
    // Generar token aleatorio
    $token = bin2hex(random_bytes(16));
    
    // Establecer expiración (1 hora)
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Eliminar tokens anteriores para este email
    $stmt = $connection->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    // Insertar nuevo token
    $stmt = $connection->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expiry);
    $stmt->execute();
    
    return $token;
}
```

### Verificar token

```php
function verifyToken($email, $token, $connection) {
    $stmt = $connection->prepare("SELECT * FROM password_resets 
                                  WHERE email = ? AND token = ? AND expiry > NOW()");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
```

### Eliminar token después de usarlo

```php
function deleteToken($email, $token, $connection) {
    $stmt = $connection->prepare("DELETE FROM password_resets WHERE email = ? AND token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
}
```

### Mantenimiento: eliminar tokens expirados

```php
function cleanupExpiredTokens($connection) {
    $stmt = $connection->prepare("DELETE FROM password_resets WHERE expiry < NOW()");
    $stmt->execute();
}
```