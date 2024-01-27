#!/bin/sh

# AWS Secrets Manager
DB_PASSWORD=$(aws secretsmanager get-secret-value --secret-id mysecret --query 'SecretString' --output text)

# Exporta a variável de ambiente
export DB_PASSWORD

# Inicia a aplicação Node.js
exec node server.js
