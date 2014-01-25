INSERT INTO users VALUES 
  (DEFAULT, 'Testi', 'testi@testaaja.com', '8e2288a2925bfa9d43141fe39e0d5f5aec8f144f82f29242a3d29f13fd878b6d', '0e48c628ac9fcc33c71c74aca7493a708b345d41c823f9d58810183e67c9c2dd', 10000,0),
  (DEFAULT, 'Mode', 'testi@testaaja.com', 'b1de29db15e8c6ac7865b8dac3915215d4b9d4a4efeecb4e728a357e94ddd696', '601bb5a6635a04ffaf903cb09750a16287dc16ea5efb4ddfd84d5f11cc7333d6', 10000,2),
  (DEFAULT, 'Admin', 'testi@testaaja.com', 'e7e47412b8a4fe035bba563116936cd8a8cd98c12be6454153497d4d3c5e317a', '15dcf25cd66bad6874818f3a6a32d4479a06a9f424b518818bf8d7489c032b86', 10000,3),
  (DEFAULT, 'Testi2', 'testi@testaaja.com', '9c311784201f2621830f8543a6dbffa35853f4f5fb888c8c5dc7e5ed73187932', '04d24d659afd08b778519c833720f00717f9aef5d78de863689ca00bc4387eed', 10000, 1);

INSERT INTO posts VALUES
  (DEFAULT, 1, 'Lorem ipsum etc etc.', '2014-01-23 12:34:56', false, NULL);

INSERT INTO topics VALUES
  (DEFAULT, 'Testi');

INSERT INTO threads VALUES
  (DEFAULT, 1, 1);

INSERT INTO thread_posts VALUES
  (1, 1);

