<?php include("includes/demo_conn.php");



public function home_banner() {
    if (isset($_POST['action'])) {
        $img_arr = array();
        try {
            /* foreach ($_POST['meta'] as $key => $val) {
              $sql = 'INSERT INTO ' . OPTIONS . ' (option_name, option_value) VALUES (?,?)';
              $this->connect()->prepare($sql)->execute([$key, $val]);
              } */
            foreach ($_POST['meta'] as $key => $val) {
                $sql = 'UPDATE banner SET option_value=? WHERE option_name=?';
                $this->connect()->prepare($sql)->execute([$val, $key]);
            }

            //File Upload
            if (isset($_FILES)) {
                $target_dir = __DIR__ . '/images/';
                
            }

            $this->wc_add_notice('success', 'Data save successfully.');
            //echo json_encode(array('status' => 'success', 'redirect' => $_POST['redirect']));
            header('Location: ' . $_POST['redirect']);
        } catch (PDOException $error) {
            $this->wc_add_notice('error', $error->getMessage());
        }
    } else {
        try {
            $sql = 'SELECT option_name, option_value FROM banner' ;
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $options = [];
            foreach ($results as $res) {
                $options[$res['option_name']] = $res['option_value'];
            }
            return $options;
        } catch (PDOException $error) {
            $this->wc_add_notice('error', $error->getMessage());
        }
    }
    die;
}






?>