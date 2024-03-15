const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = 5000;

// Middleware
 app.use(bodyParser.json());
 app.use(cors());

 // MySQL Connection
const db = mysql.createConnection({
  host: 'localhost',
    user: 'root',
       password: `Florida_239`,
         database:"dbs11591428"
        });
         // Connect
        db.connect(err => {
           if (err) {
               throw err;
                 }
                   console.log('MySQL connected...');
                  });

//                   // Routes
//
//
//                   // Start server
                  app.listen(port, () => console.log(`Server running on port ${port}`));
