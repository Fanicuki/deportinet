connection.connect((err) => {
    if (err) throw err;
    console.log('Conectado a la base de datos MySQL');
});
const express = require('express');
const app = express();
const mysql = require('mysql');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'tu_usuario',
    password: 'tu_contraseña',
    database: 'tu_base_de_datos'
});

connection.connect((err) => {
    if (err) throw err;
    console.log('Conectado a la base de datos MySQL');
});

app.get('/search', (req, res) => {
    const query = req.query.query;
    const sqlQuery = 'SELECT * FROM productos WHERE nombre LIKE ?';

    connection.query(sqlQuery, [`%${query}%`], (err, results) => {
        if (err) {
            console.error(err);
            return res.status(500).send('Error en la consulta a la base de datos');
        }
        res.json(results);
    });
});

app.listen(3000, () => {
    console.log('Servidor escuchando en el puerto 3000');
});
