<?php

function fServiceSb()
{
// Построение меню
    $a_menu = array(
        array('url' => 'self_update', 'title' => 'Обновить скрипт'),
        array('url' => 'pages', 'title' => 'Поиск страницы'),
        array('url' => 'cats', 'title' => 'Поиск раздела'),
        array('url' => 'text', 'title' => 'Поиск текстового блока'),
        array('url' => 'menu', 'title' => 'Поиск пункта меню'),
//    array('url' => 'sql-query', 'title' => 'SQL-Запросы'),
//    // array('url' => 'pages_tree', 'title' => 'Дерево разделов страниц'),
//    // array('url' => 'moduls_page', 'title' => 'Страницы модулей'),
//    array('url' => 'form_fields_moduls', 'title' => 'Поля форм модулей'),
//    // array('url' => 'missing_pages', 'title' => 'Отсутствующие страницы'),
//    array('url' => 'api', 'title' => 'API'),
//    // array('url' => 'copy_file', 'title' => 'Файл'),
        array('url' => 'php_test', 'title' => 'Тест PHP'),
        array('url' => 'php_test_dima', 'title' => 'Тест PHP Дима'),
//    // array('url' => 'news', 'title' => 'Новости'),
//    // array('url' => 'system_log', 'title' => 'Системный журнал'),
//    // array('url' => 'mail', 'title' => 'Test mail'),
        array('url' => 'design_layouts', 'title' => 'Поиск макетов дизайна элементов'),
        array('url' => 'site_layouts', 'title' => 'Поиск макетов дизайна сайта'),
        array('url' => 'related_pages', 'title' => 'Связанные с макетом дизайна сайта страницы '),
//    array('url' => 'form_related_pages', 'title' => 'Связанные с макетом дизайна формы страницы '),
        array('url' => 'text_block_related_pages', 'title' => 'Связанные с текстовым блоком страницы'),
        array('url' => 'text_block_related_site_layouts', 'title' => 'Связанные с текстовым блоком макеты дизайна сайта'),
//    array('url' => 'page_related_pages', 'title' => 'Связанные со страницей страницы'),
//    array('url' => 'page_related_site_layouts', 'title' => 'Связанные со страницей макеты дизайна сайта'),
//    array('url' => 'search_file', 'title' => 'Поиск файлов'),
//    array('url' => 'search_content_pages', 'title' => 'Поиск контента на страницах'),
//    array('url' => 'exec_moduls', 'title' => 'Запуск системных модулей из крона'),
//    array('url' => 'page_404', 'title' => 'Вывод 404 ошибки'),
    array('url' => 'file_content', 'title' => 'Контент файла'),
//    array('url' => 'soap_test', 'title' => 'Тест SOAP'),
//    // array('url' => 'create_symlink', 'title' => 'Создаем симлинк'),
//    array('url' => 'change_domain', 'title' => 'Смена доменного имени в файлах'),
    );

    if (isset($_GET['events'])) {
        // Обработка страниц
        require_once SB_CMS_LIB_PATH . '/sbMail.inc.php';
        include_once(SB_CMS_LIB_PATH . '/prog/sbFunctions.inc.php');

        foreach ($a_menu as $a_m) {
            if (isset($_GET['events']) && ($_GET['events'] != '' || $_GET['events'] != 'php_test') && $a_m['url'] == $_GET['events'] && $_GET['events'] != 'api') echo '<h1>' . $a_m['title'] . '</h1>';
        } ?>
        <script>
            document.body.onselectstart = "";
            document.body.setAttribute("unselectable", "off");
            document.body.setAttribute("oncontextmenu", "off");

            function openPageInfo(url) {
                sbShowModalDialog(url, "left=50,top=50,width=" + (screen.availWidth - 100) + ",height=" + (screen.availHeight - 100) + ",toolbars=0,location=0,status=0,menubar=0,modal=yes,resizable=1;")
            }
        </script>
        <?php

        if ($_GET['events'] == 'empty_page') {
            ?>
            <h1>Контент</h1>
            <?php
        }

        if ($_GET['events'] == 'self_update') {
            $file = 'https://raw.githubusercontent.com/Cosmonaft21/sbuilder_plugins/main/pl_service_sb.php';

            // create a new cURL resource
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $file);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            $out = curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);

            $fp = fopen(SB_CMS_PL_PATH. '/own/pl_service_sb.php', 'w');
            fwrite($fp, $out);
            fclose($fp);
        }
        if ($_GET['events'] == 'design_layouts') {
            ?>
            <form method="POST">
                    <textarea
                            name="form_text"><?php if (isset($_POST['form_text'])) echo $_POST['form_text']; ?></textarea><br>
                <label>
                    <select name="ptf_type">
                        <?php
                        $ptf_type = array(
                            'all' => 'Все',
                            'categs' => 'Список разделов',
                            'form' => 'Вывод формы',
                            'full' => 'Выбранный элемент',
                            'list' => 'Список элементов',
                            'sel_cat' => 'Выбранный раздел',
                        );
                        foreach ($ptf_type as $val => $name) {
                            $select = '';
                            if (isset($_POST['ptf_type']) && $_POST['ptf_type'] == $val || !isset($_POST['ptf_type']) && $_POST['ptf_type'] == 'all') $select = ' selected';
                            echo '<option value="' . $val . '"' . $select . '>' . $name . '</option>';
                        }
                        ?>
                    </select>
                    Тип макета</label><br>
                <label><input type="checkbox" name="ptf_title"
                              value="1" <?php echo (isset($_POST['ptf_title']) && $_POST['ptf_title'] == 1) ? ' checked' : ''; ?>>Название
                    макета дизайна</label><br>
                <label><input type="checkbox" name="ptf_form"
                              value="1" <?php echo (isset($_POST['ptf_form']) && $_POST['ptf_form'] == 1) ? ' checked' : ''; ?>>Макет
                    дизайна формы</label><br>
                <label><input type="checkbox" name="ptf_messages"
                              value="1" <?php echo (isset($_POST['ptf_messages']) && $_POST['ptf_messages'] == 1) ? ' checked' : ''; ?>>Макет
                    дизайна сообщений</label><br>
                <label><input type="checkbox" name="ptf_fields_temps"
                              value="1" <?php echo (isset($_POST['ptf_fields_temps']) && $_POST['ptf_fields_temps'] == 1) ? ' checked' : ''; ?>>Макет
                    дизайна полей формы</label><br>
                <label><input type="checkbox" name="ptf_categs_temps"
                              value="1" <?php echo (isset($_POST['ptf_categs_temps']) && $_POST['ptf_categs_temps'] == 1) ? ' checked' : ''; ?>>Макеты
                    полей разделов</label><br>
                <input type="submit">
            </form>
            <?php

            class design_layouts
            {

                /**
                 * @var array массив ID макетов
                 */
                private $design_layouts;

                /**
                 * @var boolen флаг вывода пути разделов к странице
                 */
                private $path = false;
                private $ptf_type = 'all';
                private $ptf_type_array = array();
                private $ptf_title = false;
                private $ptf_form = false;
                private $ptf_messages = false;
                private $ptf_fields_temps = false;
                private $ptf_categs_temps = false;

                public function __construct($options = array())
                {
                    $this->path = true;
                    if (isset($options['ptf_type'])) $this->ptf_type = $options['ptf_type'];
                    if (isset($options['ptf_title']) && $options['ptf_title']) $this->ptf_title = true;
                    if (isset($options['ptf_form']) && $options['ptf_form']) $this->ptf_form = true;
                    if (isset($options['ptf_messages']) && $options['ptf_messages']) $this->ptf_messages = true;
                    if (isset($options['ptf_fields_temps']) && $options['ptf_fields_temps']) $this->ptf_fields_temps = true;
                    if (isset($options['ptf_categs_temps']) && $options['ptf_categs_temps']) $this->ptf_categs_temps = true;
                }

                public function design_layouts_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    if ($text != '' && strlen($text) >= 3) {
                        switch ($this->ptf_type) {
                            case 'form':
                                $this->design_form_text($text);
                                break;
                            case 'list':
                                $this->design_list_text($text);
                                break;
                            case 'full':
                                $this->design_full_text($text);
                                break;
                            case 'categs':
                                $this->design_categs_text($text);
                                break;
                            case 'sel_cat':
                                $this->design_sel_cat_text($text);
                                break;
                            default:
                                $this->design_form_text($text);
                                $this->design_list_text($text);
                                $this->design_full_text($text);
                                $this->design_categs_text($text);
                                $this->design_sel_cat_text($text);
                        }
                    }
                }

                public function design_form_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    $query_where = array();
                    $query = 'SELECT ptf.ptf_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id INNER JOIN sb_plugins_temps_form ptf ON l.link_el_id = ptf.ptf_id WHERE c.cat_ident LIKE "pl_plugin_%_design_form"';

                    if ($this->ptf_title) $query_where[] = 'ptf.ptf_title LIKE "%' . $text . '%"';
                    if ($this->ptf_form) $query_where[] = 'ptf.ptf_form LIKE "%' . $text . '%"';
                    if ($this->ptf_messages) $query_where[] = 'ptf.ptf_messages LIKE "%' . $text . '%"';
                    if ($this->ptf_fields_temps) $query_where[] = 'ptf.ptf_fields_temps LIKE "%' . $text . '%"';
                    if ($this->ptf_categs_temps) $query_where[] = 'ptf.ptf_categs_temps LIKE "%' . $text . '%"';

                    if (count($query_where) > 0) $query_where = ' AND ' . implode(' OR ', $query_where); else return;
                    $query_group = ' GROUP BY ptf.ptf_id';
                    $res = sql_assoc($query . $query_where . $query_group);

                    if ($res)
                        foreach ($res as $value) {
                            $this->design_layouts[] = array('id' => $value['ptf_id'], 'type' => 'form');
                        }
                }

                public function design_list_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    $query_where = array();
                    $query = 'SELECT ptl.ptl_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id INNER JOIN sb_plugins_temps_list ptl ON l.link_el_id = ptl.ptl_id WHERE c.cat_ident LIKE "pl_plugin_%_design_list"';

                    $query_where[] = 'ptl.ptl_title LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_top LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_categ_top LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_element LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_empty LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_delim LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_delim LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_categ_bottom LIKE "%' . $text . '%"';
                    $query_where[] = 'ptl.ptl_bottom LIKE "%' . $text . '%"';

                    if (count($query_where) > 0) $query_where = ' AND ' . implode(' OR ', $query_where); else $query_where = '';
                    $query_group = ' GROUP BY ptl.ptl_id';
                    $res = sql_assoc($query . $query_where . $query_group);

                    if ($res)
                        foreach ($res as $value) {
                            $this->design_layouts[] = array('id' => $value['ptl_id'], 'type' => 'list');
                        }
                }

                public function design_full_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    $query_where = array();
                    $query = 'SELECT ptf.ptf_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id INNER JOIN sb_plugins_temps_full ptf ON l.link_el_id = ptf.ptf_id WHERE c.cat_ident LIKE "pl_plugin_%_design_full"';

                    $query_where[] = 'ptf.ptf_title LIKE "%' . $text . '%"';
                    $query_where[] = 'ptf.ptf_element LIKE "%' . $text . '%"';

                    if (count($query_where) > 0) $query_where = ' AND ' . implode(' OR ', $query_where); else $query_where = '';
                    $query_group = ' GROUP BY ptf.ptf_id';
                    $res = sql_assoc($query . $query_where . $query_group);

                    if ($res)
                        foreach ($res as $value) {
                            $this->design_layouts[] = array('id' => $value['ptf_id'], 'type' => 'full');
                        }
                }

                public function design_categs_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    $query_where = array();
                    $query = 'SELECT ctl.ctl_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id INNER JOIN sb_categs_temps_list ctl ON l.link_el_id = ctl.ctl_id WHERE c.cat_ident LIKE "pl_plugin_%_design_categs"';

                    $query_where[] = 'ctl.ctl_title LIKE "%' . $text . '%"';
                    $query_where[] = 'ctl.ctl_levels LIKE "%' . $text . '%"';
                    $query_where[] = 'ctl.ctl_categs_temps LIKE "%' . $text . '%"';

                    if (count($query_where) > 0) $query_where = ' AND ' . implode(' OR ', $query_where); else $query_where = '';
                    $query_group = ' GROUP BY ctl.ctl_id';
                    $res = sql_assoc($query . $query_where . $query_group);

                    if ($res)
                        foreach ($res as $value) {
                            $this->design_layouts[] = array('id' => $value['ctl_id'], 'type' => 'categs');
                        }
                }

                public function design_sel_cat_text($text)
                {
                    $text = trim($text);
                    if ($text == '') return;
                    $query_where = array();
                    $query = 'SELECT ctf.ctf_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id INNER JOIN sb_categs_temps_full ctf ON l.link_el_id = ctf.ctf_id WHERE c.cat_ident LIKE "pl_plugin_%_design_sel_cat"';

                    $query_where[] = 'ctf.ctf_title LIKE "%' . $text . '%"';
                    $query_where[] = 'ctf.ctf_temp LIKE "%' . $text . '%"';
                    $query_where[] = 'ctf.ctf_categs_temps LIKE "%' . $text . '%"';

                    if (count($query_where) > 0) $query_where = ' AND ' . implode(' OR ', $query_where); else $query_where = '';
                    $query_group = ' GROUP BY ctf.ctf_id';
                    $res = sql_assoc($query . $query_where . $query_group);

                    if ($res)
                        foreach ($res as $value) {
                            $this->design_layouts[] = array('id' => $value['ctf_id'], 'type' => 'sel_cat');
                        }
                }

                public function info()
                {
                    if (is_array($this->design_layouts) && count($this->design_layouts[0]['id']) > 0) {
                        foreach ($this->design_layouts as $design_layouts) {
                            if ($this->path) {
                                $cat_ids = sql_assoc('SELECT c.cat_id FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id WHERE c.cat_ident LIKE "pl_plugin_%_design_' . $design_layouts['type'] . '" AND l.link_el_id = ?d', intval($design_layouts['id']));
                                // var_dump($cat_ids);
                                if ($cat_ids) {
                                    $cats = array();
                                    foreach ($cat_ids as $cat) $cats[] = $cat['cat_id'];
                                    if (count($cats) > 0) {
                                        $cats = sql_assoc('SELECT c2.cat_title, c2.cat_ident FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_plugin_%_design_' . $design_layouts['type'] . '" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                        // var_dump($cats);
                                        if ($cats) {
                                            $m_title = '';
                                            $cat_ident = $cats[0]['cat_ident'];
                                            preg_match('/pl_plugin_(\d+)_design_' . $design_layouts['type'] . '/', $cat_ident, $m);
                                            // var_dump($cat_ident);
                                            if (isset($m[1])) {
                                                $res = sql_assoc('SELECT pm_title FROM sb_plugins_maker WHERE pm_id = ?d', $m[1]);
                                                if ($res) $m_title = $res[0]['pm_title'];
                                            }
                                            $cat = array();
                                            foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                            echo '<div>Модуль "' . $m_title . '"</div>';
                                            echo '<div>' . implode(' -> ', $cat) . '</div>';
                                        }
                                    }
                                }
                            }
                            switch ($design_layouts['type']) {
                                case 'form':
                                    $query = 'SELECT ptf_title as title FROM sb_plugins_temps_form WHERE ptf_id = ?d';
                                    break;
                                case 'list':
                                    $query = 'SELECT ptl_title as title FROM sb_plugins_temps_list WHERE ptl_id = ?d';
                                    break;
                                case 'full':
                                    $query = 'SELECT ptf_title as title FROM sb_plugins_temps_full WHERE ptf_id = ?d';
                                    break;
                                case 'categs':
                                    $query = 'SELECT ctl_title as title FROM sb_categs_temps_list WHERE ctl_id = ?d';
                                    break;
                                case 'sel_cat':
                                    $query = 'SELECT ctf_title as title FROM sb_categs_temps_full WHERE ctf_id = ?d';
                                    break;
                            }
                            $layout = sql_assoc($query, intval($design_layouts['id']));
                            if ($layout) {
                                echo '<div>' . $design_layouts['id'] . ' - ' . $layout[0]['title'] . '</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Макеты на найдены';
                }
            }

            $options = array();
            if (isset($_POST['ptf_type'])) $options['ptf_type'] = $_POST['ptf_type'];
            if (isset($_POST['ptf_title']) && $_POST['ptf_title'] == 1) $options['ptf_title'] = true;
            if (isset($_POST['ptf_form']) && $_POST['ptf_form'] == 1) $options['ptf_form'] = true;
            if (isset($_POST['ptf_messages']) && $_POST['ptf_messages'] == 1) $options['ptf_messages'] = true;
            if (isset($_POST['ptf_fields_temps']) && $_POST['ptf_fields_temps'] == 1) $options['ptf_fields_temps'] = true;
            if (isset($_POST['ptf_categs_temps']) && $_POST['ptf_categs_temps'] == 1) $options['ptf_categs_temps'] = true;
            $dl = new design_layouts($options);
            if (isset($_POST['form_text'])) $dl->design_layouts_text($_POST['form_text']);
            $dl->info();
        }
        if ($_GET['events'] == 'pages') {
            ?>
            <form method="POST">
                <input type="text" name="page_name"
                       value="<?= (isset($_POST['page_name'])) ? $_POST['page_name'] : '' ?>"
                       placeholder="Название страницы"><br>
                <input type="text" name="page_id" value="<?= (isset($_POST['page_id'])) ? $_POST['page_id'] : '' ?>"
                       placeholder="ID страницы"><br>
                <textarea name="page_url"
                          placeholder="URL страницы"><?= (isset($_POST['page_url'])) ? $_POST['page_url'] : '' ?></textarea><br>
                <textarea name="page_component"
                          placeholder="Текст компонента страницы"><?= (isset($_POST['page_component'])) ? $_POST['page_component'] : ''; ?></textarea><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : '' ?>>Не
                    выводить путь</label><br>
                <textarea
                        name="page_meta_text"><?= (isset($_POST['page_meta_text'])) ? $_POST['page_meta_text'] : '' ?></textarea><br>
                <label><input type="checkbox" name="p_meta"
                              value="1" <?= (isset($_POST['p_meta']) && $_POST['p_meta'] == 1) ? ' checked' : '' ?>>Доп.
                    мета-теги страницы</label><br>
                <input type="submit">
            </form>
            <?php

            class pageInfo
            {

                /**
                 * @var array массив ID страниц
                 */
                private $page_ids;

                /**
                 * @var string Название страниц
                 */
                private $page_name;

                /**
                 * @var boolen флаг вывода пути разделов к странице
                 */
                private $path = true;
                private $p_meta = false;
                private $page_meta_text = '';

                public function __construct($options = array())
                {
                    if (isset($options['path']) && $options['path']) $this->path = false;
                    if (isset($options['p_meta']) && $options['p_meta']) $this->p_meta = true;
                    if (isset($options['page_meta_text']) && trim($options['page_meta_text']) != '') $this->page_meta_text = $options['page_meta_text'];
                }

                public function pageID($id)
                {
                    $id = trim($id);
                    if ($id == '') return;
                    $this->page_ids = explode(',', $id);
                }

                public function pageURL($urls)
                {
                    $urls = trim($urls);
                    if ($urls == '') return;
                    $a_urls = explode("\r", $urls);
                    foreach ($a_urls as $url) {
                        preg_match('/(.+bmwbank.ru)?(\/.*)/', trim($url), $m);
                        // var_dump($m);
                        if (isset($m[2])) {
                            $url = $m[2];
                            $url = substr($url, 0, stripos($url, '#') ? stripos($url, '#') : strlen($url));
                            $url = substr($url, 0, stripos($url, '?') ? stripos($url, '?') : strlen($url));
                            $url = $_SERVER['DOCUMENT_ROOT'] . $url;
                            //echo $_SERVER['DOCUMENT_ROOT'].substr($m[2], 0, stripos($m[2], '?'));
                            if (substr($url, -1) == '/') $url = $url . 'index.php';
                            //echo $url.'<br>';
                            if (is_file($url)) {
                                $handle = @fopen($url, "r");
                                if ($handle) {
                                    while (($buffer = fgets($handle, 4096)) !== false) {
                                        preg_match('/define \(\'SB_PAGE_ID\', (\d+)\);/', $buffer, $m);
                                        if ($m[1]) {
                                            $this->page_ids[] = $m[1];
                                            break;
                                        }
                                    }
                                    fclose($handle);
                                }
                            } else echo 'not file';
                        }
                    }
                }

                public function pageName($name)
                {
                    $name = trim($name);
                    if ($name == '') return;
                    $pages = sql_assoc('SELECT p_id FROM sb_pages WHERE p_name LIKE "%' . $name . '%"');
                    if ($pages) {
                        foreach ($pages as $page) {
                            $this->page_ids[] = $page['p_id'];
                        }
                    }
                }

                public function pageComponents($str)
                {
                    $str = trim($str);
                    if ($str == '') return;
                    $pages = sql_assoc('SELECT p.p_id FROM sb_pages p INNER JOIN sb_elems e ON e.e_p_id = p.p_id WHERE e.e_link LIKE "page" AND e.e_params LIKE "%' . $str . '%"');
                    if ($pages) {
                        foreach ($pages as $page) {
                            $this->page_ids[] = $page['p_id'];
                        }
                    }
                }

                public function info()
                {
                    if ($this->p_meta && strlen(trim($this->page_meta_text)) > 3) {
                        $query = 'SELECT p_id FROM sb_pages WHERE p_meta LIKE "%' . trim($this->page_meta_text) . '%" GROUP BY p_id';

                        $res = sql_assoc($query);

                        if ($res)
                            $this->page_ids = array();
                        foreach ($res as $value) {
                            $this->page_ids[] = $value['p_id'];
                        }
                    }
                    if (is_array($this->page_ids) && count($this->page_ids) > 0) {
                        $domain = SB_DOMAIN;
                        foreach ($this->page_ids as $page_id) {
                            $cat_ids = sql_assoc('SELECT l.link_cat_id, l.link_src_cat_id, c.cat_id, c.cat_level, c.cat_closed
                                                        FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id 
                                                        LEFT JOIN sb_categs c ON c.cat_id = l.link_cat_id
                                                        WHERE p_id = ?d AND c.cat_ident LIKE "pl_pages"', intval($page_id));
                            $cats = $url_params = array();
                            if ($cat_ids) {
                                $url_params = array(
                                    'id' => $page_id,
                                    'ids' => $page_id,
                                    'cat_id' => $cat_ids[0]['cat_id'],
                                    'cat_level' => $cat_ids[0]['cat_level'],
                                    'cat_closed' => $cat_ids[0]['cat_closed'],
                                    'link_id' => $cat_ids[0]['link_cat_id'],
                                    'link_src_cat_id' => $cat_ids[0]['link_src_cat_id'],
                                );
                                foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                            }
                            if (count($cats) > 0) {
                                $cats = sql_assoc('SELECT c2.cat_title 
                                                    FROM sb_categs c1, sb_categs c2 
                                                    WHERE c1.cat_id IN (' . implode(',', $cats) . ')
                                                        AND c1.cat_ident LIKE "pl_pages" 
                                                        AND c1.cat_ident = c2.cat_ident 
                                                        AND c2.cat_left <= c1.cat_left 
                                                        AND c2.cat_right >= c1.cat_right 
                                                        ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) {
                                        if ($cat_name['cat_level'] == 1) {
                                            $domain = 'https://' . $cat_name['cat_title'];
                                        }
                                        $cat[] = $cat_name['cat_title'];
                                    }
                                    if ($this->path) echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $page = sql_assoc('SELECT p_name, p_filepath, p_filename FROM sb_pages WHERE p_id = ?d', intval($page_id));
                            if ($page) {
                                $url = '/cms/admin/modal_dialog.php?event=pl_pages_edit&real_event=pl_pages_init&id=' . $url_params['id'] . '&ids=' . $url_params['ids'] . '&cat_id=' . $url_params['cat_id'] . '&cat_level=' . $url_params['cat_level'] . '&cat_closed=' . $url_params['cat_closed'] . '&plugin_ident=pl_pages&link_id=' . $url_params['link_id'] . '&link_src_cat_id=' . $url_params['link_src_cat_id'];
                                echo '<div>' . $page_id . ' - ' . '<a href="javascript:void(0);" onclick="openPageInfo(\'' . $url . '\');">' . $page[0]['p_name'] . '</a> (<a href="' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '" target="_blank">' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '</a>)</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $options = array();
            if (isset($_POST['path']) && $_POST['path'] == 1) $options['path'] = true;
            if (isset($_POST['p_meta']) && $_POST['p_meta'] == 1) $options['p_meta'] = true;
            if (isset($_POST['page_meta_text']) && trim($_POST['page_meta_text']) != '') $options['page_meta_text'] = $_POST['page_meta_text'];

            $pi = new pageInfo($options);

            if (isset($_POST['page_name'])) $pi->pageName($_POST['page_name']);
            if (isset($_POST['page_id'])) $pi->pageID($_POST['page_id']);
            if (isset($_POST['page_url'])) $pi->pageURL($_POST['page_url']);
            if (isset($_POST['page_component'])) $pi->pageComponents($_POST['page_component']);

            $pi->info();
        }
        if ($_GET['events'] == 'cats') {
            ?>
            <form method="POST">
                <input type="text" name="cats_id" placeholder="ID раздела"><br>
                <input type="text" name="cat_title" placeholder="Название раздела"><br>
                <input type="text" name="cat_url" placeholder="ЧПУ раздела"><br>
                <input type="submit">
            </form>
            <?php

            class catsInfo
            {

                /**
                 * @var array массив ID страниц
                 */
                private $cats_ids = array();

                public function catsID($id)
                {
                    $this->cats_ids = explode(',', $id);
                }

                public function catTitle($title)
                {
                    if (trim($title) != '') {
                        $cats = sql_assoc('SELECT cat_id FROM sb_categs WHERE cat_title LIKE "%' . trim($title) . '%"');
                        if ($cats) {
                            $this->cats_ids = array();
                            foreach ($cats as $cat) {
                                $this->cats_ids[] = $cat['cat_id'];
                            }
                        }
                    }
                }

                public function catURL($url)
                {
                    if (trim($url) != '') {
                        $cats = sql_assoc('SELECT cat_id FROM sb_categs WHERE cat_url LIKE "%' . trim($url) . '%"');
                        if ($cats) {
                            $this->cats_ids = array();
                            foreach ($cats as $cat) {
                                $this->cats_ids[] = $cat['cat_id'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->cats_ids) && !$this->cats_ids[0]) echo 'Не указан ID раздела';
                    foreach ($this->cats_ids as $cats_id) {
                        $cats = sql_assoc('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (?d) AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC', intval($cats_id));
                        if ($cats) {
                            $cat = array();
                            foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                            echo '<div>' . $cats_id . ' - ' . implode(' -> ', $cat) . '</div>';
                        }
                    }
                }
            }

            $ci = new catsInfo();
            if (isset($_POST['cats_id'])) $ci->catsID($_POST['cats_id']);
            if (isset($_POST['cat_title'])) $ci->catTitle($_POST['cat_title']);
            if (isset($_POST['cat_url'])) $ci->catURL($_POST['cat_url']);
            $ci->info();
        }
        if ($_GET['events'] == 'text') {
            ?>
            <form method="POST">
                <input type="text" name="text_id" placeholder="ID текстового блока"
                       value="<?= (isset($_POST['text_id'])) ? $_POST['text_id'] : '' ?>"><br>
                <textarea name="text"><?= (isset($_POST['text'])) ? $_POST['text'] : '' ?></textarea><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : '' ?>>
                    Выводить путь</label><br>
                <input type="submit">
            </form>
            <?php

            class Texts
            {

                /**
                 * @var array массив ID страниц
                 */
                private $texts_ids;

                /**
                 * @var boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path = true)
                {
                    $this->path = $path;
                }

                public function textID($id)
                {
                    $this->texts_ids = explode(',', $id);
                }

                public function texts_text($text)
                {
                    if (trim($text) != '' && strlen(trim($text)) > 3) {
                        $res = sql_assoc('SELECT t.t_id FROM sb_catlinks l LEFT JOIN sb_categs c ON l.link_cat_id = c.cat_id LEFT JOIN sb_texts t ON l.link_el_id = t.t_id WHERE c.cat_ident LIKE "pl_texts" AND t_html LIKE "%' . $text . '%" GROUP BY t.t_id');

                        if ($res)
                            foreach ($res as $value) {
                                $this->texts_ids[] = $value['t_id'];
                            }
                    }
                }

                public function info()
                {
                    if (is_array($this->texts_ids) && count($this->texts_ids[0]) > 0) {
                        foreach ($this->texts_ids as $texts_id) {
                            $cat_ids = sql_assoc('SELECT l.link_cat_id, l.link_src_cat_id, c.cat_id, c.cat_level, c.cat_closed
                                                        FROM sb_texts t LEFT JOIN sb_catlinks l ON t.t_id = l.link_el_id 
                                                        LEFT JOIN sb_categs c ON c.cat_id = l.link_cat_id
                                                        WHERE t.t_id = ?d AND c.cat_ident LIKE "pl_texts"', intval($texts_id));
                            $cats = $url_params = array();
                            if ($cat_ids) {
                                $url_params = array(
                                    'id' => $texts_id,
                                    'ids' => $texts_id,
                                    'cat_id' => $cat_ids[0]['cat_id'],
                                    'cat_level' => $cat_ids[0]['cat_level'],
                                    'cat_closed' => $cat_ids[0]['cat_closed'],
                                    'link_id' => $cat_ids[0]['link_cat_id'],
                                    'link_src_cat_id' => $cat_ids[0]['link_src_cat_id'],
                                );
                                foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                            }
                            if (count($cats) > 0) {
                                $cats = sql_assoc('SELECT c2.cat_title 
                                            FROM sb_categs c1, sb_categs c2 
                                            WHERE c1.cat_id IN (' . implode(',', $cats) . ') 
                                            AND c1.cat_ident LIKE "pl_texts" 
                                            AND c2.cat_ident = c1.cat_ident 
                                            AND c2.cat_left <= c1.cat_left 
                                            AND c2.cat_right >= c1.cat_right 
                                            ORDER BY c2.cat_left ASC');
                                // var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    if ($this->path) echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $texts = sql_assoc('SELECT t_name FROM sb_texts WHERE t_id = ?d', intval($texts_id));
                            if ($texts) {
                                $url = '/cms/admin/modal_dialog.php?event=pl_texts_edit&real_event=pl_texts_init&id=' . $url_params['id'] . '&ids=' . $url_params['ids'] . '&cat_id=' . $url_params['cat_id'] . '&cat_level=' . $url_params['cat_level'] . '&cat_closed=' . $url_params['cat_closed'] . '&plugin_ident=pl_texts&link_id=' . $url_params['link_id'] . '&link_src_cat_id=' . $url_params['link_src_cat_id'];
                                echo '<div>' . $texts_id . ' - ' . '<a href="javascript:void(0);" onclick="openPageInfo(\'' . $url . '\');">' . $texts[0]['t_name'] . '</a></div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Текстовые блоки не найдены';
                }
            }

            $t = new Texts(isset($_POST['path'])&&$_POST['path']==1);
            if (isset($_POST['text_id'])) $t->textID($_POST['text_id']);
            if (isset($_POST['text'])) $t->texts_text($_POST['text']);
            $t->info();
        }
        if ($_GET['events'] == 'menu') {
            ?>
            <form method="POST">
                <input type="text" name="menu_id" placeholder="ID пункта меню"
                       value="<?php if (isset($_POST['menu_id'])) echo $_POST['menu_id']; ?>"><br>
                <input type="text" name="menu_url" placeholder="URL страницы пункта меню"
                       value="<?php if (isset($_POST['menu_url'])) echo $_POST['menu_url']; ?>"><br>
                <label><input type="checkbox" name="menu_submenu"
                              value="1" <?php echo (isset($_POST['menu_submenu']) && $_POST['menu_submenu'] == 1) ? ' checked' : ''; ?>>Вывести
                    все пункты данного меню</label><br>
                <input type="submit">
            </form>
            <?php

            class menuInfo
            {

                /**
                 * @var array массив ID пунктов
                 */
                private $menu_ids = array();

                /**
                 * @var boolen флаг вывода пунктов меню раздела
                 */
                private $submenu = false;

                public function __construct($options = array())
                {
                    if (isset($options['submenu']) && $options['submenu']) $this->submenu = true;
                }

                public function menuID($id)
                {
                    $this->menu_ids = explode(',', $id);
                }

                public function menuURL($url)
                {
                    preg_match('/(.+' . SB_DOMAIN . ')?(\/.*)/', $url, $m);
                    //var_dump($m);
                    if (isset($m[2])) {
                        $url = substr($m[2], 0, stripos($m[2], '?') ? stripos($m[2], '?') : strlen($m[2]));
                        $res = sql_assoc('SELECT m_id FROM sb_menu WHERE m_url LIKE "%' . $m[2] . '%"');
                        if ($res) {
                            foreach ($res as $value) {
                                $this->menu_ids[] = $value['m_id'];
                            }
                        }
                    } else echo 'Нет такого пункта';
                }

                public function info()
                {
                    if (count($this->menu_ids) == 0) echo 'Не указан ID пункта меню';
                    foreach ($this->menu_ids as $i => $menu_id) {

                        $cats = sql_query('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (SELECT m_cat_id FROM sb_menu WHERE m_id = ?d) AND c1.cat_ident LIKE "pl_menu" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC', intval($menu_id));
                        if ($cats) {
                            $cat = array();
                            foreach ($cats as $cat_name) $cat[] = $cat_name[0];
                            echo '<div>' . implode(' -> ', $cat) . '</div>';
                        }

                        $menus = sql_query('SELECT m2.m_title FROM sb_menu m1, sb_menu m2 WHERE m1.m_id = ?d AND m2.m_cat_id = m1.m_cat_id AND m2.m_left <= m1.m_left AND m2.m_right >= m1.m_right ORDER BY m2.m_left ASC', intval($menu_id));
                        if ($menus) {
                            $punkt = array();
                            foreach ($menus as $menu) $punkt[] = $menu[0];
                            echo '<div>' . implode(' -> ', $punkt) . '</div>';
                        }
                        $menu = sql_assoc('SELECT m_url, m_id, m_cat_id FROM sb_menu WHERE m_id = ?d', intval($menu_id));
                        if ($menu) {
                            echo '<div>(id = ' . $menu[0]['m_id'] . ', cat_id = ' . $menu[0]['m_cat_id'] . ', ' . $menu[0]['m_url'] . ') </div>';
                        }
                        echo '<br>';

                        if ($this->submenu) {
                            $query = 'SELECT m2.m_id, m2.m_title, m2.m_url, m2.m_left, m2.m_right, m2.m_level FROM sb_menu m1, sb_menu m2 WHERE m1.m_id = ?d AND m2.m_cat_id = m1.m_cat_id ORDER BY m2.m_left ASC';
                            $res = sql_assoc($query, $menu_id);
                            if ($res) {
                                echo '<table>';
                                foreach ($res as $v) {
                                    echo '<tr>';
                                    foreach ($v as $n => $f) echo '<td>' . $n . '</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    foreach ($v as $n => $f) echo '<td>' . $f . '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo '<style>';
                                echo 'table td { border: 1px solid}';
                                echo '</style>';
                            }
                        }
                    }
                }
            }

            $options = array();
            if (isset($_POST['menu_submenu']) && $_POST['menu_submenu'] == 1) $options['submenu'] = true;

            $mi = new menuInfo($options);

            if (isset($_POST['menu_id'])) $mi->menuID($_POST['menu_id']);
            if (isset($_POST['menu_url'])) $mi->menuURL($_POST['menu_url']);

            $mi->info();
        }
        if ($_GET['events'] == 'php_test') {
            include_once SB_CMS_PL_PATH . '/own/pl_service_sb/php_test_cosmo.php';
        }
        if ($_GET['events'] == 'php_test_dima') {
            include_once SB_CMS_PL_PATH . '/own/pl_service_sb/php_test_dima.php';
        }
        if ($_GET['events'] == 'change_domain') {
            ?>
            <form method="POST">
                <input type="text" name="file_name" placeholder="Название файла"
                       value="<?php if (isset($_POST['file_name'])) echo $_POST['file_name']; ?>">
                <input type="text" name="search_text" placeholder="Искомый текст"
                       value="<?php if (isset($_POST['search_text'])) echo $_POST['search_text']; ?>">
                <label><input type="checkbox" name="replace_text"
                              value="1" <?php echo (isset($_POST['replace_text']) && $_POST['replace_text'] == 1) ? ' checked' : ''; ?>>Заменить
                    текст</label><br>
                <input type="submit">
            </form>
            <?php
            echo $_SERVER['DOCUMENT_ROOT'];

            // смена доменного имени в файлах сайта
            class SearchFile
            {

                /**
                 * @param string $search_text - искомый текст
                 */
                private $search_text;

                /**
                 * @param boolean $replace_text - флаг замены текста
                 */
                private $replace_text = false;

                /**
                 * @param array $replaceText - массив заменяемых строк
                 */
                private $replaceText = array(
                    'bmwbank.ru' => 'bmwbank.ru',
                );

                /**
                 * @param string $file_name - Навзание файла
                 */
                private $file_name;

                /**
                 * @param string $folderName - пусть до папки
                 */
                private $folderName;

                // список файлов стилей, использующих файл иконок
                private $searching_files = array();

                public function __construct($file_name = '.php', $search_text = '', $replace_text = false)
                {
                    $this->file_name = $file_name;
                    $this->search_text = $search_text;
                    $this->replace_text = $replace_text;
                    $this->folderName = $_SERVER['DOCUMENT_ROOT'];
                }

                private function replaceText($text)
                {
                    if (!is_array($this->replaceText) || count($this->replaceText) == 0) {
                        return $text;
                    } else {
                        $keys = array_keys($this->replaceText);
                        $values = array_values($this->replaceText);

                        // обработка сериализованных массивов
                        $matches = array();
                        $result = preg_match_all('#\s\'(a:\d+:\{.*?\})\'\s#s', $text, $matches);
                        if (!$result) {
                            $result = preg_match_all('#\s\'(s:\d+:\\\\".*?\\\\";)\'\s#s', $text, $matches);
                        }
                        if (!$result) {
                            $result = preg_match_all('\'(s:\d+:\\\\".*?\\\\";)\'', $text, $matches);
                        }

                        if ($result) {
                            $search = array();
                            $replace = array();
                            $replace_tmp = array();

                            $i = 0;
                            foreach ($matches[1] as $match) {
                                if (!in_array($match, $search)) {
                                    $ar = @unserialize(str_replace(array('\\\'', '\\"', '\r', '\n', '\\r', '\\n'), array('\'', '"', "\r", "\n", "\r", "\n"), $match));

                                    if ($ar !== false) {
                                        $ar = sb_array_replace($keys, $values, $ar);
                                        $search[] = $match;
                                        $replace[] = trim($GLOBALS['sbSql']->escape(serialize($ar)), "'");
                                        $replace_tmp[] = '!!**sb_tmp_replacer_' . $i . '**!!';

                                        $i++;
                                    }
                                }
                            }

                            $text = str_replace($search, $replace_tmp, $text);
                            $text = sb_str_replace($keys, $values, $text);

                            return str_replace($replace_tmp, $replace, $text);
                        }

                        return sb_str_replace($keys, $values, $text);
                    }
                }

                /**
                 * Поиск файла по имени во всех папках и подпапках
                 *
                 * @param string $folderName - пусть до папки
                 */
                public function info($folderName = '')
                {
                    if (trim($folderName) != '') $this->folderName = $folderName;
                    echo '<h2>Поиск в разделе ' . $this->folderName . '</h2><br>';
                    $this->search_file($this->folderName);

                    // вывод списков
                    foreach ($this->searching_files as $file) {
                        $content = $file['content'];
                        $replace_content = $this->replaceText($content);
                        if ($content != $replace_content) {
                            echo '<b>' . str_replace($_SERVER['DOCUMENT_ROOT'], SB_DOMAIN, $file['name']) . '</b><br><textarea style="width: 100%; height: 100px">' . htmlspecialchars($content) . '</textarea><br><textarea style="width: 100%; height: 100px">' . htmlspecialchars($replace_content) . '</textarea><br>';
                            if ($this->replace_text) file_put_contents($file['name'], $replace_content);
                        } else {
                            echo '<b>' . str_replace($_SERVER['DOCUMENT_ROOT'], SB_DOMAIN, $file['name']) . '</b><br>';
                        }
                    }
                }

                private function search_file($folderName)
                {
                    // открываем текущую папку
                    $dir = opendir($folderName);

                    // перебираем папку
                    while (($file = readdir($dir)) !== false) { // перебираем пока есть файлы
                        if ($file != "." && $file != "..") { // если это не папка
                            if (is_file($folderName . "/" . $file)) { // если файл проверяем имя
                                // если имя файла нужное, то вернем путь до него
                                if (strpos($file, $this->file_name) !== false) {
                                    if ($this->search_text != '') {
                                        $content = file_get_contents($folderName . "/" . $file);
                                        if (strpos($content, $this->search_text) !== false) {
                                            $this->searching_files[] = array(
                                                'name' => $folderName . "/" . $file,
                                                'content' => file_get_contents($folderName . "/" . $file)
                                            );
                                        }
                                    } else {
                                        $this->searching_files[] = array(
                                            'name' => $folderName . "/" . $file,
                                            'content' => file_get_contents($folderName . "/" . $file)
                                        );
                                    }
                                }
                            }
                            // если папка, то рекурсивно вызываем search_file
                            if (is_dir($folderName . "/" . $file)) $this->search_file($folderName . "/" . $file);
                        }
                    }

                    // закрываем папку
                    closedir($dir);
                }
            }

            $replace_text = (isset($_POST['replace_text']) && $_POST['replace_text'] == 1) ? true : false;
            $st = new SearchFile($_POST['file_name'], $_POST['search_text'], $replace_text);
            $st->info('/home/bmwbank/web/bmwbank.ru/public_html/cms/backup/table_dump');
//            $st->info();
//            $st->info('/home/bmwbank/web/bmwbank.ru/public_html');


            // проверка вывода текстового блока
            /*//$query = 'SELECT t_id, t_name, t_html, t_old_html FROM sb_texts WHERE t_name LIKE "%www.rosbank.ru%" OR t_html LIKE "%www.rosbank.ru%" OR t_old_html LIKE "%www.rosbank.ru%"';
            //$query = 'SELECT n_id, n_short, n_full, user_f_72, user_f_63, user_f_75, user_f_53, user_f_54, user_f_26, user_f_77, user_f_78, user_f_79, user_f_82 FROM sb_news WHERE n_short LIKE "%www.rosbank.ru%" OR n_full LIKE "%www.rosbank.ru%" OR user_f_72 LIKE "%www.rosbank.ru%" OR user_f_63 LIKE "%www.rosbank.ru%" OR user_f_75 LIKE "%www.rosbank.ru%" OR user_f_53 LIKE "%www.rosbank.ru%" OR user_f_54 LIKE "%www.rosbank.ru%" OR user_f_26 LIKE "%www.rosbank.ru%" OR user_f_77 LIKE "%www.rosbank.ru%" OR user_f_78 LIKE "%www.rosbank.ru%" OR user_f_79 LIKE "%www.rosbank.ru%" OR user_f_82 LIKE "%www.rosbank.ru%"';
            $res = sql_assoc($query);
            if ($res) {
                foreach ($res as $row) {
                    $n_short = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['n_short']);
                    $n_full = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['n_full']);
                    $user_f_72 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_72']);
                    $user_f_63 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_63']);
                    $user_f_75 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_75']);
                    $user_f_53 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_53']);
                    $user_f_54 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_54']);
                    $user_f_26 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_26']);
                    $user_f_77 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_77']);
                    $user_f_78 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_78']);
                    $user_f_79 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_79']);
                    $user_f_82 = str_replace('www.bmwbank.ru', 'www.old.bmwbank.ru', $row['user_f_82']);

                    sql_query('UPDATE sb_news SET n_short = ?, n_full = ?, user_f_72 = ?, user_f_63 = ?, user_f_75 = ?, user_f_53 = ?, user_f_54 = ?, user_f_26 = ?, user_f_77 = ?, user_f_78 = ?, user_f_79 = ?, user_f_82 = ? WHERE n_id = ?d', $n_short, $n_full, $user_f_72, $user_f_63, $user_f_75, $user_f_53, $user_f_54, $user_f_26, $user_f_77, $user_f_78, $user_f_79, $user_f_82, intval($row['n_id']));
                }
            }*/

            // Проверка файла импорта объектов недвижимости
            /*$filename = SB_BASEDIR.'/upload/import/pl_plugin_109.csv';

            if (($handle = fopen($filename, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 4096, ";", '"')) !== FALSE) {
                    var_dump($data);
                    //break;
                }
                fclose($handle);
            }*/


            // проверка листов рассылки
            /*include_once(SB_CMS_PL_PATH.'/pl_news/prog/pl_news.php');
            $ml_news_ids = array();
            $maillist_id = 47;

    //		Достаем идентификаторы новостей которые еще не отправлялись, но которые надо отправить в текущей рассылке.
            $news = sql_query('SELECT n.n_id, c.cat_id FROM sb_news n, sb_categs c WHERE CONCAT("|", n.n_ml_ids) LIKE "%|'.intval($maillist_id).'|%"
                        AND (CONCAT("|", n.n_ml_ids_sent) NOT LIKE "%|'.intval($maillist_id).'|%" OR n.n_ml_ids_sent IS NULL OR n.n_ml_ids_sent = "")
                        AND c.cat_ident="pl_news" AND c.cat_level=0');

            var_dump($news);
            $root_cat_id = 0;
            if($news)
            {
                foreach($news as $val)
                {
                    $ml_news_ids[] = $val[0];
                }
                $root_cat_id = isset($news[0][1]) ? $news[0][1] : 0;
            }
            var_dump($ml_news_ids);

            $news_html = '';

            $params = array();
            $params['ids'] = $root_cat_id;
            $params['temp_id'] = 70;
            $params['filter'] = 'all';
            $params['sort1'] = 'n.n_date';
            $params['sort2'] = 'n.n_title';
            $params['sort3'] = '';
            $params['order1'] = 'DESC';
            $params['order2'] = 'DESC';
            $params['order3'] = '';
            $params['page'] = '';
            $params['subcategs'] = 1;
            $params['rubrikator'] = 0;
            $params['cloud'] = 0;
            $params['calendar'] = 0;
            $params['use_filter'] = 0;
            $params['moderate'] = 1;
            $params['moderate_email'] = '';
            $params = addslashes(serialize($params));

            $news_ids = array(); // массив идентификаторов новостей которые попали в вывод новостей для рассылки.
            $news_html = fNews_Elem_List('0', '70', $params, '1', $ml_news_ids);
            var_dump($news_html);
            $ml_news_ids = array(18400,18405);*/


            // Проверка промокодов
            /*$res = sql_assoc('SELECT c.* FROM promocodes c INNER JOIN sb_plugins_116 p ON c.code = p.user_f_9 WHERE code NOT LIKE "%2018-1111-1111-11%"
                AND (code LIKE "%rzd%"
                OR code LIKE "%vip%"
                OR code LIKE "%svk%"
                OR code LIKE "%eld%"
                OR code LIKE "%spb%"
                OR code LIKE "%mas%"
                OR code LIKE "%рфа%"
                OR type LIKE "CLR"
                OR type LIKE "SVA")
                AND flag LIKE "used"
                GROUP BY code');*/

            /*if ($res)
                foreach ($res as $row) {
                    $data = array(
                        'flag' => 'used'
                    );
                    $res = sql_query('UPDATE promocodes SET ?a WHERE code LIKE "'.$row['code'].'"', $data);
                }*/
            /*if(
                sb_strpos($code, 'rzd') !== false ||
                sb_strpos($code, 'vip') !== false ||
                sb_strpos($code, 'svk') !== false ||
                sb_strpos($code, 'eld') !== false ||
                sb_strpos($code, 'spb') !== false ||
                sb_strpos($code, 'mas') !== false ||
                ($res && ($res[0][0] == 'CLR' || $res[0][0] == 'SVA') && (sb_strpos($code, '2018-1111-1111-11') === false ) ) ||
                sb_strpos($code, 'рфа') !== false
            ) {

                $code = trim(sb_strtoupper('{PROMOKOD_9}'));
                $data = array(
                    'flag' => 'used'
                );
                $res = sql_query('UPDATE promocodes SET ?a WHERE code LIKE "'.$code.'"', $data);

                if (sb_strpos($code, 'rzd') !== false)
                {
                    $res = sql_query('UPDATE promocodes SET ?a WHERE code LIKE "'.sb_str_replace('rzd','',$code).'"', $data);
                }
            }*/

            // получаю вложени с почтового ящика
            /*require_once SB_BASEDIR.'/system/PhpImap/Mailbox.php';
            // 4. argument is the directory into which attachments are to be saved:
            $mailbox = new PhpImap\Mailbox('{imap.gmail.com:993/imap/ssl}INBOX', 'ab@binn.ru', 'AsXyuYVukVD9', SB_BASEDIR.'/attachments/');

            // Read all messaged into an array:
            $mailsIds = $mailbox->searchMailbox('ALL');
            if(!$mailsIds) {
                die('Mailbox is empty');
            }

            // Get the first message and save its attachment(s) to disk:
            $mail = $mailbox->getMail($mailsIds[0]);

            print_r($mail);
            echo "\n\nAttachments:\n";
            print_r($mail->getAttachments());*/

            // меняем m_left и m_right у пунктов меню
            /*$querys = array(
                'UPDATE sb_menu SET m_left=48,m_right=49 WHERE m_id=5847',
                'UPDATE sb_menu SET m_left=50,m_right=53 WHERE m_id=5837',
                'UPDATE sb_menu SET m_left=51,m_right=52 WHERE m_id=5838',
                'UPDATE sb_menu SET m_left=54,m_right=57 WHERE m_id=5839',
                'UPDATE sb_menu SET m_left=55,m_right=56 WHERE m_id=5840',
                'UPDATE sb_menu SET m_left=58,m_right=75 WHERE m_id=5848',
                'UPDATE sb_menu SET m_left=59,m_right=60 WHERE m_id=5851',
                'UPDATE sb_menu SET m_left=61,m_right=62 WHERE m_id=5852',
                'UPDATE sb_menu SET m_left=63,m_right=64 WHERE m_id=5849'
            );
            foreach ($querys as $query) {
                sql_query($query);
            }*/

            // проверка вывода текстового блока
            /*$query = 'SELECT t_name as name, t_html as html FROM sb_texts WHERE t_id = ?d';
            $text = sql_assoc($query, 4055);
            if ($text) {
                $text = $text[0];
                ob_start();
                eval('?>'.$text['name'].'<?php');
                echo $subject = ob_get_clean();

                ob_start();
                eval('?>'.$text['html'].'<?php');
                echo $html = ob_get_clean();
            }*/

            //получаю все элементы с id
            /*$ext_id = array(
                    505,660,507,662,508,509,663,664,511,666,512,513,514,515,516,517,518,519,520,667,668,669,670,671,672,673,674,675,521,676,527,681,682,683,529,530,531,684,685,686,523,524,525,533,534,535,536,537,538,539,540,678,679,680,688,689,690,691,692,693,694,695,541,543,544,545,546,547,696,697,698,699,700,701,702,549,550,704,705,551,552,706,707,553,554,555,556,557,708,709,710,711,712,558,559,560,561,562,713,714,715,716,717,563,564,718,719,565,566,567,568,569,570,571,572,573,574,575,576,578,579,720,721,722,723,724,725,726,727,728,729,730,731,732,733,734,580,581,582,583,584,585,586,587,588,735,736,737,738,739,740,741,742,743,589,590,591,744,745,746,592,593,747,748,594,595,596,597,598,749,750,751,752,753,600,601,602,754,755,756,757,603,604,758,759,606,760,761,610,611,765,766,613,767,768,614,769,607,608,615,616,617,618,619,620,621,622,623,624,625,626,627,628,629,630,631,632,633,634,635,636,637,638,762,763,770,771,772,773,774,775,776,777,778,779,780,781,782,783,784,785,786,787,788,789,790,791,792,793,640,641,795,796,642,658,797,644,799,646,647,648,801,802,803,649,650,651,652,804,805,806,807,653,654,655,656,808,809,810,811,504,659,506,661,510,665,522,677,532,687,548,703,609,764,639,794,643,798,645,800
            );
            $query = 'SELECT p_id FROM sb_plugins_109 ORDER BY p_id ASC';
            $res = sql_assoc($query);*/

            /*$ext_id = array(
                505,660,507,662,508,509,663,664,511,666,512,513,514,515,516,517,518,519,520,667,668,669,670,671,672,673,674,675,521,676,527,681,682,683,529,530,531,684,685,686,523,524,525,533,534,535,536,537,538,539,540,678,679,680,688,689,690,691,692,693,694,695,541,543,544,545,546,547,696,697,698,699,700,701,702,549,550,704,705,551,552,706,707,553,554,555,556,557,708,709,710,711,712,558,559,560,561,562,713,714,715,716,717,563,564,718,719,565,566,567,568,569,570,571,572,573,574,575,576,578,579,720,721,722,723,724,725,726,727,728,729,730,731,732,733,734,580,581,582,583,584,585,586,587,588,735,736,737,738,739,740,741,742,743,589,590,591,744,745,746,592,593,747,748,594,595,596,597,598,749,750,751,752,753,600,601,602,754,755,756,757,603,604,758,759,606,760,761,610,611,765,766,613,767,768,614,769,607,608,615,616,617,618,619,620,621,622,623,624,625,626,627,628,629,630,631,632,633,634,635,636,637,638,762,763,770,771,772,773,774,775,776,777,778,779,780,781,782,783,784,785,786,787,788,789,790,791,792,793,640,641,795,796,642,658,797,644,799,646,647,648,801,802,803,649,650,651,652,804,805,806,807,653,654,655,656,808,809,810,811,504,659,506,661,510,665,522,677,532,687,548,703,609,764,639,794,643,798,645,800
            );
            $query = 'SELECT l.* FROM sb_catlinks l INNER JOIN sb_categs c ON l.link_cat_id = c.cat_id WHERE c.cat_ident LIKE "pl_plugin_109" ORDER BY link_el_id ASC';
            $query = 'SELECT cat_id FROM sb_categs WHERE cat_ident LIKE "pl_plugin_109" ORDER BY cat_id ASC';
            $res = sql_assoc($query);*/

            /*$file_catlinks = 'sb_catlinks.txt';
            $file_plugin = 'sb_plugins_109.txt';
            $sql = file_get_contents($file_plugin);
            //$sql = 'DELETE FROM sb_catlinks WHERE link_cat_id IN (SELECT cat_id FROM sb_categs WHERE cat_ident LIKE "pl_plugin_109") AND link_el_id IN (2887,2888,2889,2890,2891,2892,2893,2894,2895,2896,2897,2898,2899,2900,2901,2902,2903);';
            //$sql = 'SELECT * FROM sb_catlinks WHERE link_cat_id 5054,5085,5039,5055,5060,5060,5057,5058,5059,5060,5060,5060,5060,5060,5060,5060,5089,5061,5061,5063,5047,5056,5056,5056';
            //$sql = "DELETE FROM sb_plugins_109 WHERE 1";
            $res = sql_query($sql);*/


            // находим все страницы для заявок на обзвон
            /*$ids = array(1150700,1150701,1150702,1150703,1150704,1150705,1150706,1150707,1150708,1150709,1150710,1150711,1150712,1150713,1150714,1150715,1150716,1150717,1150719,1150720,1150721,1150724,1150725,1150727,1150728,1150729,1150730,1150731,1150732,1150733,1150734,1150735,1150736,1150737,1150738,1150739,1150740,1150741,1150742,1150743,1150744,1150745,1150746,1150748,1150750,1150751,1150752,1150753,1150754,1150757,1150758,1150759,1150760,1150761,1150763,1150765,1150766,1150769,1150773,1150775,1150776,1150777,1150778,1150779,1150781,1150782,1150783,1150784,1150786,1150787,1150788,1150789,1150790,1150791,1150792,1150795,1150796,1150798,1150800,1150801,1150802,1150803,1150804,1150806,1150807,1150808,1150809,1150811,1150812,1150813,1150814,1150816,1150817,1150819,1150820,1150822,1150823,1150824,1150825,1150826,1150827,1150828,1150829,1150830,1150831,1150832,1150834,1150836,1150837,1150838,1150839,1150840,1150841,1150842,1150843,1150844,1150845,1150847,1150849,1150850,1150851,1150852,1150853,1150854,1150855,1150856,1150857,1150858,1150859,1150860,1150861,1150862,1150863,1150864,1150865,1150866,1150867,1150868,1150869,1150870,1150871,1150872,1150873,1150874,1150875,1150876,1150877,1150878,1150879,1150880,1150881,1150882,1150883,1150884,1150885,1150886,1150887,1150888,1150889,1150890,1150891,1150892,1150893,1150894,1150895,1150896,1150897,1150898,1150899,1150900,1150901,1150902,1150903,1150904,1150905,1150906,1150907,1150908,1150909,1150910,1150911,1150913,1150914,1150915,1150916,1150917,1150918,1150919,1150920,1150921,1150922,1150923,1150924,1150925,1150926,1150927,1150928,1150929,1150930,1150931,1150932,1150933,1150934,1150935,1150936,1150937,1150938,1150939,1150940,1150941,1150942,1150943,1150944,1150945,1150946,1150947,1150948,1150949,1150950,1150951,1150952,1150953,1150954,1150955,1150956,1150957,1150958,1150959,1150960,1150961,1150962,1150963,1150964,1150965,1150966,1150967,1150968,1150969,1150970,1150971,1150972,1150973,1150974,1150975,1150976,1150977,1150978,1150979,1150980,1150981,1150982,1150983,1150984,1150985,1150986,1150987,1150988,1150989,1150990,1150991,1150992,1150993,1150994,1150995,1150996,1150997,1150998,1150999,1151000,1151001,1151002,1151003,1151004,1151005,1151006,1151007,1151008,1151009,1151010,1151011,1151013,1151014,1151015,1151016,1151017,1151018,1151019,1151020,1151021,1151022,1151023,1151024,1151025,1151026,1151027,1151028,1151029,1151030,1151031,1151032,1151033,1151034,1151035,1151036,1151037,1151038,1151039,1151040,1151041,1151042,1151043,1151044,1151045,1151046,1151047,1151048,1151049,1151050,1151051,1151052,1151055,1151056,1151057,1151058,1151059,1151060,1151061,1151062,1151063,1151064,1151065,1151066,1151067,1151068,1151069,1151070,1151071,1151072,1151073,1151074,1151075,1151076,1151077,1151078,1151079,1151080,1151081,1151082,1151083,1151084,1151085,1151086,1151087,1151088,1151089,1151090,1151091,1151092,1151093,1151094,1151095,1151096,1151098,1151099,1151100,1151101,1151102,1151103,1151104,1151105,1151106,1151107,1151108,1151109,1151110,1151111,1151112,1151113,1151114,1151115,1151116,1151117,1151118,1151119,1151120,1151121,1151122,1151123,1151124,1151125,1151126,1151127,1151128,1151129,1151130,1151131,1151132,1151133,1151134,1151135,1151136,1151137,1151139,1151140,1151141,1151142,1151143,1151144,1151145,1151146,1151147,1151148,1151149,1151151,1151152,1151153,1151154,1151155,1151157,1151158,1151160,1151161,1151162,1151163,1151164,1151165,1151166,1151167,1151168,1151169,1151170,1151171,1151172,1151173,1151174,1151175,1151176,1151177,1151178,1151179,1151180,1151181,1151182,1151183,1151184,1151185,1151186,1151187,1151188,1151189,1151190,1151191,1151192,1151194,1151195,1151196,1151197,1151198,1151199,1151200,1151201,1151202,1151203,1151204,1151205,1151206,1151207,1151208,1151209,1151210,1151211,1151213,1151214,1151215,1151216,1151217,1151218,1151219,1151220,1151221,1151222,1151223,1151225,1151226,1151227,1151228,1151229,1151230,1151231,1151232,1151233,1151234,1151235,1151236,1151237,1151238,1151239,1151240,1151241,1151242,1151243,1151244,1151245,1151246,1151247,1151248,1151249,1151250,1151251,1151252,1151253,1151254,1151255,1151256,1151257,1151258,1151259,1151260,1151261,1151262,1151263,1151264,1151265,1151266,1151267,1151269,1151270,1151271,1151272,1151273,1151274,1151275,1151276,1151277,1151278,1151279,1151280,1151281,1151282,1151283,1151284,1151285,1151286,1151287,1151288,1151289,1151290,1151291,1151292,1151293,1151294,1151295,1151296,1151297,1151298,1151299,1151300,1151301,1151302,1151303,1151304,1151305,1151306,1151307,1151308,1151309,1151310,1151311,1151312,1151313,1151314,1151315,1151318,1151319,1151320,1151321,1151322,1151323,1151324,1151325,1151326,1151327,1151328,1151329,1151330,1151331,1151332,1151333,1151334,1151335,1151336,1151337,1151338,1151340,1151341,1151342,1151343,1151344,1151345,1151346,1151347,1151348,1151349,1151350,1151351,1151352,1151353,1151354,1151355,1151356,1151357,1151358,1151359,1151360,1151361,1151362,1151363,1151364,1151365,1151366,1151367,1151368,1151369,1151370,1151371,1151372,1151373,1151374,1151376,1151377,1151378,1151379,1151381,1151382,1151383,1151384,1151385,1151388,1151389,1151390,1151391,1151392,1151393,1151394,1151395,1151396,1151398,1151399,1151400,1151401,1151402,1151403,1151404,1151405,1151406,1151407,1151408,1151409,1151410,1151411,1151412,1151414,1151415,1151416,1151417,1151418,1151419,1151420,1151421,1151422,1151423,1151424,1151425,1151426,1151427,1151428,1151429,1151430,1151431,1151432,1151433,1151434,1151435,1151436,1151437,1151438,1151439,1151440,1151441,1151442,1151443,1151444,1151445,1151446,1151447,1151448,1151449,1151450,1151451,1151452,1151453,1151455,1151456,1151457,1151458,1151459,1151460,1151461,1151462,1151463,1151464,1151465,1151466,1151467,1151468,1151469,1151470,1151471,1151472,1151473,1151474,1151475,1151476,1151477,1151478,1151479,1151480,1151481,1151482,1151483,1151484,1151485,1151486,1151487,1151488,1151489,1151490,1151491,1151492,1151493,1151494,1151495,1151496,1151497,1151498,1151499,1151500,1151501,1151502,1151503,1151504,1151505,1151506,1151507,1151508,1151509,1151510,1151511,1151512,1151513,1151514,1151515,1151516,1151517,1151518,1151520,1151521,1151522,1151523,1151524,1151525,1151526,1151527,1151528,1151529,1151530,1151531,1151532,1151533,1151534,1151535,1151536,1151537,1151538,1151539,1151540,1151541,1151542,1151543,1151544,1151545,1151546,1151547,1151548,1151549,1151550,1151551,1151552,1151553,1151554,1151555,1151556,1151557,1151558,1151559,1151560,1151561,1151562,1151563,1151564,1151565,1151566,1151567,1151568,1151569,1151570,1151571,1151572,1151573,1151574,1151575,1151576,1151577,1151578,1151579,1151580,1151581,1151582,1151583,1151584,1151585,1151586,1151587,1151588,1151589,1151591,1151592,1151593,1151594,1151595,1151596,1151597,1151598,1151599,1151600,1151601,1151602,1151603,1151604,1151605,1151606,1151607,1151608,1151609,1151610,1151612,1151614,1151615,1151616,1151617,1151618,1151619,1151620,1151621,1151622,1151623,1151624,1151625,1151626,1151627,1151628,1151629,1151630,1151631,1151632,1151633,1151634,1151635,1151636,1151637,1151638,1151639,1151640,1151641,1151643,1151644,1151645,1151646,1151647,1151648,1151650,1151651,1151652,1151653,1151654,1151655,1151656,1151657,1151658,1151659,1151660,1151661,1151662,1151663,1151664,1151665,1151666,1151667,1151668,1151669,1151670,1151671,1151672,1151673,1151674,1151675,1151676,1151677,1151678,1151679,1151680,1151681,1151682,1151683,1151684,1151685,1151686,1151688,1151689,1151690,1151691,1151692,1151693,1151694,1151695,1151696,1151697,1151698,1151699,1151700,1151701,1151702,1151703,1151704,1151705,1151706,1151707,1151708,1151710,1151711,1151712,1151713,1151714,1151715,1151716,1151717,1151718,1151719,1151720,1151721,1151722,1151723,1151724,1151725,1151726,1151727,1151728,1151729,1151730,1151731,1151732,1151733,1151734,1151735,1151736,1151737,1151738,1151739,1151740,1151741,1151743,1151744,1151745,1151746,1151747,1151748,1151749,1151750,1151751,1151752,1151753,1151754,1151755,1151756,1151757,1151758,1151759,1151760,1151762,1151763,1151764,1151765,1151766,1151767,1151768,1151769,1151770,1151771,1151772,1151773,1151774,1151775,1151776,1151777,1151778,1151779,1151780,1151781,1151782,1151783,1151784,1151786,1151787,1151788,1151790,1151791,1151792,1151793,1151794,1151795,1151796,1151797,1151798,1151799,1151800,1151801,1151802,1151803,1151804,1151805,1151806,1151807,1151808,1151809,1151810,1151811,1151813,1151814,1151815,1151816,1151817,1151818,1151819,1151820,1151821,1151822,1151823,1151824,1151825,1151826,1151827,1151828,1151829,1151830,1151831,1151833,1151834,1151835,1151836,1151838,1151839,1151840,1151841,1151842,1151843,1151844,1151845,1151846,1151847,1151848,1151849,1151850,1151851,1151852,1151853,1151854,1151855,1151856,1151857,1151858,1151859,1151860,1151862,1151863,1151864,1151865,1151866,1151867,1151868,1151869,1151870,1151871,1151872,1151873,1151874,1151875,1151876,1151877,1151878,1151879,1151880,1151881,1151883,1151884,1151885,1151886,1151887,1151888,1151889,1151890,1151891,1151892,1151893,1151894,1151895,1151896,1151898,1151899,1151900,1151902,1151903,1151904,1151905,1151907,1151908,1151909,1151910,1151911,1151912,1151913,1151914,1151915,1151916,1151917,1151918,1151919,1151920,1151921,1151923,1151924,1151925,1151926,1151927,1151928,1151929,1151931,1151933,1151934,1151935,1151936,1151937,1151938,1151939,1151940,1151941,1151942,1151943,1151944,1151945,1151946,1151947,1151948,1151949,1151950,1151951,1151952,1151953,1151954,1151955,1151956,1151957,1151958,1151959,1151960,1151961,1151962,1151963,1151964,1151965,1151966,1151967,1151968,1151969,1151970,1151971,1151972,1151973,1151974,1151975,1151976,1151977,1151978,1151979,1151980,1151981,1151982,1151983,1151984,1151985,1151986,1151987,1151988,1151989,1151990,1151991,1151992,1151993,1151994,1151995,1151996,1151997,1151999,1152000,1152002,1152003,1152004,1152005,1152006,1152007,1152008,1152009,1152010,1152011,1152012,1152013,1152014,1152017,1152018,1152019,1152020,1152021,1152022,1152023,1152024,1152025,1152026,1152027,1152028,1152029,1152030,1152031,1152032,1152033,1152034,1152035,1152036,1152037,1152038,1152039,1152040,1152041,1152042,1152043,1152044,1152045,1152046,1152047,1152048,1152049,1152050,1152051,1152052,1152053,1152054,1152055,1152057,1152058,1152059,1152060,1152061,1152062,1152063,1152064,1152065,1152066,1152067,1152068,1152069,1152070,1152071,1152072,1152073,1152074,1152075,1152076,1152077,1152078,1152079,1152080,1152081,1152082,1152083,1152084,1152085,1152086,1152087,1152088,1152089,1152090,1152091,1152092,1152093,1152094,1152095,1152096,1152097,1152098,1152099,1152100,1152101,1152102,1152103,1152104,1152105,1152106,1152107,1152108,1152109,1152110,1152111,1152112,1152113,1152114,1152115,1152116,1152117,1152118,1152119,1152120,1152121,1152122,1152123,1152124,1152125,1152126,1152127,1152128,1152129,1152130,1152131,1152132,1152133,1152134,1152135,1152136,1152137,1152138,1152139,1152140,1152141,1152142,1152143,1152144,1152145,1152146,1152147,1152148,1152149,1152150,1152151,1152152,1152153,1152154,1152155,1152156,1152157,1152158,1152159,1152160,1152161,1152162,1152163,1152164,1152165,1152166,1152167,1152168,1152169,1152170,1152171,1152172,1152173,1152174,1152175,1152176,1152177,1152178,1152179,1152180,1152181,1152183,1152184,1152185,1152187,1152188,1152189,1152190,1152191,1152192,1152193,1152194,1152195,1152196,1152197,1152198,1152199,1152200,1152201,1152202,1152203,1152204,1152205,1152206,1152207,1152208,1152209,1152210,1152211,1152212,1152213,1152214,1152215,1152216,1152217,1152218,1152219,1152220,1152221,1152222,1152223,1152224,1152225,1152227,1152228,1152229,1152230,1152231,1152232,1152233,1152234,1152235,1152236,1152237,1152238,1152239,1152240,1152241,1152242,1152243,1152244,1152245,1152246,1152247,1152248,1152249,1152251,1152252,1152253,1152254,1152255,1152256,1152257,1152258,1152259,1152260,1152261,1152262,1152263,1152264,1152265,1152266,1152267,1152268,1152269,1152270,1152271,1152272,1152273,1152274,1152275,1152276,1152277,1152279,1152280,1152281,1152282,1152283,1152284,1152285,1152286,1152287,1152288,1152289,1152290,1152291,1152292,1152293,1152294,1152295,1152296,1152297,1152298,1152299,1152300,1152301,1152302,1152303,1152304,1152305,1152306,1152307,1152308,1152309,1152310,1152311,1152312,1152313,1152314,1152315,1152316,1152317,1152318,1152319,1152320,1152321,1152322,1152323,1152325,1152326,1152327,1152328,1152329,1152330,1152331,1152332,1152333,1152334,1152335,1152336,1152337,1152338,1152339,1152340,1152341,1152342,1152343,1152344,1152345,1152346,1152347,1152348,1152349,1152350,1152352,1152353,1152354,1152355,1152356,1152357,1152358,1152359,1152360,1152361,1152362,1152363,1152364,1152365,1152366,1152367,1152368,1152369,1152370,1152371,1152372,1152373,1152374,1152375,1152376,1152377,1152378,1152379,1152380,1152381,1152382,1152383,1152384,1152385,1152386,1152387,1152388,1152389,1152390,1152391,1152392,1152393,1152394,1152395,1152396,1152397,1152398,1152399,1152400,1152401,1152402,1152403,1152404,1152405,1152406,1152407,1152408,1152409,1152410,1152411,1152412,1152413,1152414,1152415,1152416,1152417,1152418,1152419,1152420,1152421,1152422,1152423,1152424,1152425,1152426,1152427,1152428,1152429,1152430,1152431,1152432,1152433,1152434,1152435,1152436,1152437,1152438,1152439,1152440,1152441,1152442,1152444,1152445,1152446,1152447,1152448,1152449,1152450,1152451,1152452,1152453,1152454,1152455,1152456,1152457,1152458,1152459,1152460,1152461,1152462,1152463,1152464,1152465,1152466,1152467,1152468,1152469,1152470,1152471,1152475,1152476,1152477,1152478,1152479,1152480,1152481,1152482,1152483,1152484,1152485,1152486,1152487,1152488,1152489,1152490,1152491,1152492,1152493,1152494,1152496,1152497,1152498,1152499,1152500,1152501,1152502,1152503,1152504,1152505,1152506,1152507,1152508,1152509,1152510,1152511,1152512,1152513,1152514,1152515,1152516,1152517,1152518,1152519,1152520,1152521,1152522,1152523,1152524,1152525,1152526,1152527,1152529,1152530,1152531,1152532,1152533,1152534,1152536,1152537,1152538,1152539,1152540,1152541,1152542,1152544,1152545,1152546,1152547,1152548,1152549,1152550,1152551,1152552,1152553,1152554,1152555,1152556,1152557,1152558,1152559,1152560,1152561,1152562,1152563,1152564,1152565,1152566,1152567,1152570,1152571,1152572,1152573,1152574,1152575,1152576,1152577,1152578,1152579,1152580,1152581,1152582,1152583,1152584,1152585,1152586,1152587,1152588,1152589,1152590,1152591,1152592,1152593,1152594,1152595,1152596,1152597,1152598,1152599,1152600,1152601,1152602,1152603,1152604,1152605,1152606,1152607,1152608,1152609,1152610,1152611,1152613,1152614,1152615,1152616,1152617,1152618,1152619,1152620,1152621,1152622,1152623,1152624,1152625,1152626,1152627,1152628,1152630,1152631,1152632,1152633,1152634,1152635,1152636,1152637,1152638,1152639,1152640,1152641,1152642,1152643,1152644,1152645,1152646,1152647,1152648,1152649,1152650,1152651,1152652,1152653,1152654,1152655,1152656,1152657,1152658,1152659,1152660,1152661,1152662,1152663,1152664,1152665,1152666,1152668,1152670,1152671,1152672,1152673,1152674,1152675,1152676,1152677,1152678,1152679,1152680,1152681,1152682,1152683,1152684,1152687,1152688,1152689,1152690,1152691,1152692,1152693,1152694,1152695,1152697,1152698,1152699,1152700,1152701,1152702,1152703,1152704,1152705,1152706,1152707,1152708,1152709,1152710,1152711,1152712,1152713,1152714,1152715,1152716,1152717,1152718,1152719,1152720,1152721,1152722,1152723,1152724,1152725,1152726,1152727,1152728,1152729,1152730,1152731,1152732,1152733,1152734,1152735,1152736,1152737,1152738,1152739,1152741,1152742,1152743,1152744,1152745,1152746,1152747,1152748,1152749,1152750,1152751,1152752,1152753,1152754,1152755,1152756,1152758,1152759,1152760,1152761,1152762,1152763,1152764,1152765,1152766,1152767,1152768,1152769,1152770,1152771,1152772,1152773,1152774,1152775,1152776,1152777,1152778,1152779,1152780,1152781,1152782,1152783,1152784,1152785,1152786,1152787,1152788,1152789,1152790,1152791,1152792,1152793,1152794,1152795,1152796,1152797,1152798,1152799,1152800,1152801,1152802,1152803,1152805,1152806,1152807,1152808,1152809,1152810,1152813,1152814,1152815,1152817,1152818,1152820,1152821,1152822,1152823,1152824,1152826,1152827,1152828,1152829,1152830,1152831,1152832,1152833,1152834,1152835,1152836,1152837,1152838,1152839,1152840,1152841,1152842,1152843,1152845,1152846,1152847,1152848,1152849,1152850,1152851,1152852,1152853,1152854,1152855,1152856,1152857,1152858,1152859,1152860,1152861,1152938,1152939,1152940,1152941,1152942,1152943,1152944,1152945,1152947,1152948,1152950,1152951,1152952,1152953,1152954,1152956,1152957,1152959,1152961,1152962,1152963,1152964,1152965,1152966,1152967,1152968,1152969,1152970,1152972,1152974,1152975,1152976,1152977,1152978,1152980,1152981,1152982,1152983,1152984,1152986,1152987,1152988,1152989,1152990,1152992,1152993,1152994,1152995,1152996,1152997,1152999,1153000,1153001,1153002,1153004,1153005,1153008,1153010,1153011,1153013,1153014,1153015,1153018,1153020,1153023,1153024,1153025,1153026,1153031,1153032,1153033,1153035,1153036,1153037,1153040,1153041,1153042,1153043,1153044,1153048,1153049,1153050,1153051,1153054,1153056,1153057,1153058,1153059,1153062,1153065,1153069,1153070,1153071,1153073,1153079,1153081,1153084,1153085,1153087,1153088,1153089,1153091,1153093,1153094,1153096,1153097,1153098,1153100,1153102,1153103,1153104,1153106,1153107,1153108,1153109,1153111,1153112,1153113,1153114,1153115,1153116,1153117,1153118,1153119,1153120,1153121,1153123,1153124,1153125,1153126,1153127,1153128,1153129,1153130,1153131,1153132,1153133,1153134,1153135,1153138,1153139,1153140,1153141,1153143,1153144,1153145,1153146,1153147,1153149,1153151,1153152,1153153,1153154,1153155,1153156,1153157,1153158,1153159,1153160,1153161,1153162,1153163,1153164,1153165,1153166,1153167,1153168,1153169,1153170,1153171,1153172,1153173,1153174,1153175,1153176,1153177,1153178,1153179,1153180,1153181,1153182,1153183,1153184,1153185,1153186,1153187,1153188,1153189,1153190,1153191,1153192,1153193,1153195,1153196,1153197,1153198,1153199,1153200,1153201,1153202,1153203,1153204,1153205,1153206,1153207,1153208,1153209,1153210,1153211,1153212,1153213,1153214,1153215,1153216,1153217,1153218,1153219,1153220,1153221,1153222,1153223,1153225,1153226,1153227,1153228,1153231,1153232,1153233,1153234,1153235,1153236,1153237,1153238,1153239,1153240,1153241,1153242,1153243,1153244,1153245,1153246,1153247,1153248,1153250,1153251,1153252,1153253,1153254,1153255,1153256,1153257,1153259,1153260,1153261,1153262,1153263,1153264,1153265,1153266,1153268,1153270,1153272,1153274,1153275,1153276,1153277,1153278,1153279,1153280,1153281,1153282,1153283,1153286,1153287,1153288,1153289,1153290,1153292,1153293,1153294,1153295,1153296,1153297,1153298,1153299,1153300,1153301,1153302,1153303,1153304,1153305,1153306,1153307,1153308,1153309,1153310,1153311,1153312,1153313,1153314,1153315,1153316,1153317,1153318,1153319,1153320,1153321,1153322,1153323,1153324,1153325,1153326,1153327,1153328,1153329,1153330,1153331,1153332,1153333,1153335,1153336,1153337,1153338,1153339,1153340,1153341,1153342,1153343,1153344,1153345,1153346,1153347,1153348,1153349,1153350,1153351,1153352,1153353,1153355,1153356,1153357,1153358,1153359,1153360,1153362,1153364,1153365,1153366,1153367,1153368,1153370,1153371,1153372,1153373,1153374,1153375,1153376,1153377,1153378,1153379,1153380,1153381,1153382,1153383,1153384,1153385,1153386,1153387,1153388,1153389,1153390,1153391,1153392,1153393,1153394,1153395,1153396,1153397,1153398,1153399,1153400,1153401,1153403,1153404,1153405,1153406,1153407,1153408,1153409,1153410,1153411,1153412,1153413,1153414,1153415,1153416,1153417,1153418,1153419,1153420,1153421,1153422,1153423,1153424,1153425,1153426,1153427,1153428,1153429,1153430,1153431,1153432,1153433,1153434,1153435,1153436,1153437,1153438,1153439,1153440,1153441,1153442,1153443,1153444,1153445,1153446,1153447,1153448,1153449,1153450,1153451,1153452,1153453,1153454,1153455,1153456,1153457,1153458,1153459,1153460,1153461,1153462,1153463,1153464,1153465,1153466,1153467,1153468,1153469,1153471,1153472,1153473,1153475,1153476,1153477,1153478,1153479,1153480,1153481,1153482,1153483,1153484,1153485,1153486,1153487,1153488,1153491,1153492,1153493,1153494,1153495,1153496,1153497,1153498,1153499,1153500,1153501,1153503,1153504,1153505,1153506,1153507,1153508,1153509,1153510,1153511,1153512,1153514,1153515,1153516,1153517,1153518,1153519,1153520,1153521,1153522,1153523,1153524,1153525,1153526,1153527,1153528,1153529,1153530,1153532,1153533,1153534,1153535,1153536,1153537,1153538,1153539,1153541,1153542,1153543,1153544,1153545,1153546,1153547,1153548,1153549,1153550,1153551,1153552,1153554,1153555,1153556,1153557,1153558,1153559,1153560,1153561,1153562,1153563,1153564,1153565,1153566,1153567,1153568,1153569,1153570,1153571,1153572,1153573,1153574,1153575,1153576,1153577,1153579,1153580,1153581,1153582,1153583,1153584,1153585,1153586,1153588,1153589,1153590,1153591,1153592,1153593,1153594,1153595,1153596,1153597,1153598,1153599,1153601,1153602,1153603,1153604,1153605,1153606,1153607,1153608,1153609,1153611,1153612,1153613,1153614,1153615,1153616,1153617,1153618,1153619,1153620,1153622,1153624,1153627,1153628,1153629,1153630,1153631,1153632,1153633,1153634,1153635,1153636,1153637,1153638,1153639,1153643,1153644,1153646,1153647,1153648,1153649,1153650,1153651,1153652,1153653,1153654,1153655,1153656,1153657,1153659,1153660,1153661,1153662,1153663,1153665,1153666,1153667,1153668,1153669,1153670,1153671,1153672,1153674,1153675,1153677,1153678,1153679,1153680,1153681,1153682,1153683,1153684,1153685,1153686,1153687,1153688,1153689,1153690,1153691,1153692,1153693,1153695,1153696,1153697,1153698,1153699,1153700,1153701,1153702,1153703,1153704,1153705,1153706,1153707,1153708,1153709,1153711,1153712,1153713,1153714,1153716,1153717,1153718,1153719,1153720,1153721,1153722,1153723,1153724,1153725,1153726,1153727,1153728,1153729,1153730,1153731,1153732,1153733,1153736,1153737,1153738,1153739,1153740,1153741,1153742,1153744,1153745,1153746,1153747,1153748,1153750,1153751,1153752,1153753,1153754,1153755,1153756,1153757,1153759,1153760,1153761,1153763,1153765,1153766,1153767,1153768,1153769,1153770,1153771,1153772,1153773,1153774,1153776,1153777,1153778,1153779,1153780,1153781,1153782,1153783,1153784,1153785,1153786,1153789,1153790,1153791,1153792,1153794,1153795,1153796,1153797,1153800,1153801,1153802,1153803,1153804,1153805,1153806,1153807,1153808,1153809,1153810,1153811,1153812,1153813,1153814,1153815,1153816,1153817,1153818,1153819,1153820,1153821,1153822,1153823,1153826,1153827,1153830,1153831,1153832,1153833,1153836,1153837,1153838,1153839,1153842,1153844,1153845,1153846,1153848,1153850,1153852,1153853,1153854,1153855,1153856,1153858,1153859,1153861,1153862,1153864,1153865,1153866,1153867,1153868,1153869,1153870,1153871,1153872,1153873,1153874,1153875,1153876,1153879,1153880,1153882,1153883,1153884,1153885,1153887,1153888,1153889,1153891,1153892,1153893,1153894,1153895,1153896,1153897,1153900,1153901,1153902,1153903,1153904,1153905,1153906,1153907,1153908,1153909,1153910,1153911,1153912,1153913,1153914,1153915,1153916,1153917,1153918,1153919,1153920,1153921,1153923,1153924,1153925,1153926,1153927,1153928,1153929,1153930,1153931,1153932,1153933,1153934,1153935,1153936,1153937,1153938,1153939,1153940,1153941,1153942,1153943,1153944,1153945,1153946,1153947,1153948,1153949,1153950,1153951,1153952,1153953,1153954,1153955,1153957,1153958,1153959,1153960,1153961,1153962,1153963,1153964,1153965,1153966,1153967,1153968,1153969,1153970,1153973,1153974,1153975,1153976,1153977,1153978,1153979,1153980,1153981,1153982,1153983,1153984,1153985,1153986,1153987,1153989,1153990,1153991,1153994,1153995,1153998,1153999,1154000,1154001,1154002,1154003,1154004,1154005,1154006,1154007,1154008,1154009,1154010,1154011,1154013,1154014,1154015,1154016,1154017,1154018,1154019,1154021,1154022,1154023,1154024,1154025,1154027,1154028,1154029,1154030,1154031,1154033,1154035,1154036,1154037,1154038,1154039,1154040,1154041,1154042,1154044,1154047,1154048,1154053,1154054,1154055,1154056,1154057,1154058,1154059,1154060,1154061,1154062,1154065,1154066,1154067,1154068,1154069,1154070,1154072,1154073,1154075,1154076,1154077,1154078,1154079,1154080,1154082,1154083,1154084,1154085,1154086,1154087,1154088,1154089,1154090,1154091,1154092,1154094,1154095,1154097,1154098,1154100,1154101,1154102,1154103,1154104,1154105,1154106,1154107,1154108,1154109,1154110,1154111,1154112,1154113,1154114,1154115,1154117,1154119,1154120,1154121,1154122,1154123,1154124,1154125,1154126,1154127,1154128,1154129,1154130,1154131,1154132,1154133,1154135,1154136,1154137,1154138,1154139,1154140,1154141,1154142,1154143,1154144,1154145,1154147,1154148,1154149,1154151,1154152,1154153,1154154,1154156,1154157,1154158,1154159,1154160,1154161,1154162,1154163,1154164,1154165,1154166,1154167,1154168,1154169,1154170,1154171,1154172,1154173,1154174,1154175,1154176,1154177,1154180,1154181,1154182,1154183,1154186,1154187,1154188,1154189,1154190,1154191,1154192,1154193,1154194,1154195,1154198,1154199,1154200,1154201,1154203,1154204,1154205,1154206,1154207,1154208,1154209,1154210,1154211,1154212,1154213,1154217,1154218,1154219,1154220,1154221,1154222,1154223,1154224,1154225,1154226,1154227,1154228,1154229,1154230,1154232,1154233,1154234,1154236,1154237,1154239,1154241,1154242,1154243,1154244,1154245,1154246,1154247,1154248,1154249,1154250,1154251,1154252,1154253,1154255,1154256,1154257,1154258,1154260,1154261,1154262,1154263,1154264,1154265,1154266,1154267,1154268,1154269,1154270,1154271,1154272,1154273,1154274,1154275,1154278,1154280,1154281,1154282,1154283,1154285,1154287,1154288,1154289,1154291,1154292,1154293,1154294,1154295,1154296,1154297,1154298,1154299,1154300,1154301,1154302,1154303,1154304,1154305,1154306,1154307,1154308,1154309,1154310,1154311,1154312,1154313,1154315,1154316,1154317,1154318,1154319,1154320,1154321,1154322,1154323,1154324,1154326,1154327,1154328,1154329,1154331,1154332,1154333,1154334,1154335,1154337,1154338,1154339,1154340,1154341,1154343,1154344,1154345,1154346,1154347,1154348,1154349,1154350,1154351,1154352,1154353,1154354,1154356,1154357,1154358,1154360,1154362,1154363,1154365,1154366,1154367,1154368,1154369,1154370,1154372,1154373,1154374,1154375,1154376,1154377,1154379,1154380,1154381,1154382,1154384,1154385,1154387,1154389,1154390,1154391,1154392,1154393,1154394,1154395,1154396,1154397,1154398,1154399,1154400,1154401,1154402,1154403,1154405,1154406,1154407,1154412,1154414,1154415,1154416,1154417,1154418,1154419,1154420,1154422,1154423,1154424,1154426,1154427,1154428,1154429,1154430,1154431,1154432,1154434,1154435,1154436,1154437,1154438,1154439,1154440,1154441,1154442,1154445,1154446,1154447,1154450,1154451,1154452,1154453,1154454,1154455,1154456,1154457,1154459,1154460,1154461,1154462,1154463,1154464,1154465,1154466,1154467,1154468,1154469,1154471,1154472,1154473,1154474,1154475,1154476,1154477,1154478,1154480,1154482,1154485,1154486,1154487,1154488,1154489,1154490,1154491,1154492,1154494,1154496,1154497,1154498,1154499,1154501,1154502,1154503,1154504,1154505,1154506,1154507,1154509,1154510,1154511,1154512,1154513,1154515,1154516,1154517,1154519,1154520,1154521,1154522,1154523,1154524,1154525,1154526,1154529,1154530,1154531,1154533,1154534,1154535,1154536,1154537,1154538,1154539,1154540,1154541,1154542,1154544,1154545,1154546,1154547,1154548,1154549,1154550,1154551,1154552,1154553,1154554,1154555,1154556,1154557,1154558,1154559,1154560,1154561,1154563,1154564,1154565,1154566,1154567,1154568,1154569,1154570,1154571,1154572,1154574,1154576,1154577,1154578,1154582,1154583,1154584,1154585,1154586,1154587,1154588,1154589,1154590,1154591,1154592,1154593,1154594,1154595,1154597,1154598,1154599,1154600,1154602,1154603,1154604,1154605,1154606,1154607,1154608,1154610,1154612,1154613,1154614,1154615,1154616,1154617,1154618,1154619,1154621,1154622,1154623,1154624,1154627,1154628,1154629,1154630,1154631,1154632,1154633,1154635,1154636,1154637,1154638,1154639,1154641,1154642,1154643,1154644,1154645,1154646,1154648,1154653,1154654,1154655,1154656,1154657,1154658,1154659,1154660,1154661,1154662,1154663,1154664,1154665,1154666,1154667,1154668,1154669,1154670,1154671,1154672,1154673,1154674,1154675,1154676,1154677,1154678,1154679,1154680,1154681,1154682,1154683,1154684,1154685,1154686,1154687,1154688,1154689,1154690,1154692,1154693,1154694,1154695,1154696,1154697,1154698,1154699,1154700,1154702,1154703,1154704,1154706,1154707,1154708,1154709,1154712,1154713,1154715,1154716,1154717,1154718,1154719,1154720,1154721,1154722,1154723,1154724,1154725,1154727,1154730,1154731,1154732,1154733,1154734,1154735,1154736,1154737,1154738,1154739,1154740,1154742,1154743,1154744,1154745,1154747,1154748,1154749,1154750,1154751,1154752,1154753,1154754,1154755,1154757,1154759,1154761,1154762,1154763,1154764,1154765,1154766,1154768,1154769,1154770,1154771,1154772,1154773,1154774,1154775,1154776,1154777,1154778,1154779,1154780,1154781,1154782,1154783,1154784,1154785,1154786,1154787,1154788,1154789,1154790,1154791,1154792,1154793,1154794,1154795,1154796,1154797,1154798,1154800,1154801,1154802,1154803,1154805,1154806,1154807,1154808,1154810,1154811,1154812,1154813,1154814,1154815,1154816,1154817,1154818,1154819,1154820,1154821,1154822,1154823,1154825,1154826,1154827,1154828,1154829,1154831,1154832,1154834,1154835,1154836,1154837,1154838,1154839,1154840,1154841,1154842,1154843,1154844,1154845,1154846,1154847,1154848,1154850,1154851,1154853,1154854,1154855,1154856,1154857,1154858,1154859,1154860,1154861,1154862,1154863,1154864,1154865,1154866,1154868,1154869,1154870,1154871,1154872,1154873,1154874,1154875,1154876,1154877,1154878,1154879,1154880,1154882,1154884,1154886,1154888,1154889,1154890,1154891,1154892,1154893,1154894,1154895,1154896,1154897,1154898,1154899,1154901,1154902,1154903,1154904,1154905,1154906,1154907,1154908,1154909,1154910,1154911,1154912,1154913,1154914,1154915,1154916,1154917,1154918,1154919,1154920,1154921,1154923,1154924,1154926,1154927,1154928,1154929,1154930,1154931,1154932,1154933,1154934,1154935,1154936,1154937,1154938,1154939,1154943,1154944,1154945,1154946,1154947,1154948,1154949,1154950,1154951,1154952,1154953,1154954,1154955,1154956,1154957,1154958,1154959,1154960,1154961,1154962,1154963,1154964,1154965,1154966,1154967,1154969,1154970,1154971,1154972,1154973,1154974,1154975,1154976,1154977,1154978,1154979,1154981,1154982,1154983,1154984,1154986,1154990,1154991,1154992,1154994,1154995,1154996,1154997,1154998,1154999,1155000,1155001,1155002,1155003,1155005,1155006,1155007,1155008,1155009,1155010,1155011,1155013,1155014,1155015,1155016,1155018,1155019,1155020,1155021,1155022,1155023,1155024,1155025,1155026,1155027,1155028,1155029,1155030,1155031,1155032,1155033,1155034,1155035,1155036,1155037,1155039,1155040,1155041,1155042,1155043,1155045,1155047,1155048,1155049,1155051,1155052,1155053,1155054,1155055,1155056,1155057,1155058,1155059,1155060,1155061,1155062,1155063,1155064,1155065,1155067,1155068,1155070,1155071,1155072,1155073,1155074,1155075,1155076,1155077,1155078,1155079,1155080,1155081,1155082,1155084,1155085,1155086,1155087,1155088,1155089,1155090,1155091,1155092,1155093,1155094,1155095,1155096,1155097,1155098,1155099,1155100,1155102,1155103,1155104,1155105,1155106,1155107,1155108,1155109,1155110,1155111,1155114,1155115,1155116,1155117,1155118,1155119,1155120,1155121,1155122,1155123,1155124,1155125,1155126,1155127,1155128,1155129,1155130,1155131,1155132,1155133,1155134,1155135,1155136,1155137,1155138,1155139,1155140,1155141,1155142,1155143,1155145,1155146,1155147,1155152,1155153,1155154,1155155,1155156,1155157,1155158,1155159,1155161,1155163,1155164,1155165,1155166,1155168,1155169,1155170,1155171,1155172,1155173,1155174,1155177,1155178,1155179,1155180,1155182,1155183,1155184,1155185,1155186,1155187,1155188,1155189,1155191,1155192,1155193,1155194,1155196,1155197,1155198,1155199,1155202,1155203,1155205,1155207,1155208,1155209,1155210,1155211,1155212,1155213,1155215,1155216,1155218,1155219,1155220,1155221,1155222,1155224,1155226,1155228,1155230,1155231,1155232,1155233,1155234,1155235,1155236,1155237,1155238,1155239,1155240,1155241,1155242,1155243,1155244,1155245,1155247,1155248,1155249,1155250,1155252,1155253,1155254,1155256,1155257,1155258,1155259,1155263,1155264,1155265,1155266,1155268,1155269,1155270,1155271,1155272,1155273,1155275,1155276,1155277,1155278,1155279,1155280,1155281,1155284,1155285,1155286,1155287,1155288,1155289,1155290,1155291,1155292,1155295,1155296,1155297,1155298,1155301,1155302,1155303,1155304,1155305,1155307,1155308,1155309,1155311,1155312,1155313,1155314,1155315,1155317,1155318,1155319,1155322,1155323,1155327,1155328,1155334,1155335,1155336,1155337,1155338,1155344,1155345,1155350,1155351,1155352,1155353,1155355,1155358,1155360,1155362,1155365,1155366,1155367,1155371,1155372,1155373,1155374,1155377,1155378,1155380,1155381,1155382,1155383,1155384,1155386,1155388,1155391,1155392,1155393,1155394,1155395,1155396,1155399,1155400,1155401,1155404,1155405,1155406,1155407,1155409,1155411,1155412,1155413,1155414,1155415,1155418,1155419,1155421,1155422,1155423,1155426,1155427,1155429,1155430,1155431,1155432,1155434,1155435,1155438,1155439,1155447,1155448,1155449,1155451,1155452,1155454,1155455,1155457,1155458,1155459,1155460,1155461,1155462,1155463,1155464,1155465,1155466,1155468,1155469,1155470,1155471,1155472,1155476,1155477,1155478,1155479,1155480,1155482,1155483,1155484,1155485,1155492,1155493,1155494,1155495,1155499,1155500,1155501,1155503,1155504,1155508,1155509,1155510,1155512,1155514,1155515,1155516,1155517,1155519,1155520,1155521,1155522,1155523,1155525,1155526,1155527,);
            $query = 'SELECT user_f_54 FROM sb_plugins_113 WHERE p_id IN (?a) GROUP BY user_f_54';
            $res = sql_assoc($query, $ids);*/

            // создание таблицы plugin_109_log в системе. НЕТ ПРАВ СОЗДАВАТЬ ТАБЛИЦЫ
            /*$query = "CREATE TABLE IF NOT EXISTS `plugin_109_log` (
    `l_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
    `l_date` int(11) UNSIGNED NOT NULL COMMENT 'Дата записи',
    `l_el_id` int(10) UNSIGNED NOT NULL COMMENT 'Идентификатор элемента',
    `l_el_title` varchar(255) NOT NULL COMMENT 'Название элемента',
    `l_type` int(10) UNSIGNED NOT NULL COMMENT 'Тип записи',
    UNIQUE KEY `l_id` (`l_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Журнал Витрина имущества';";
            if (!sql_query($query)) sb_add_system_message('Не удалось создать таблицу для журнала');*/

            // добавляю элементы в модуль "Банковкие дни"
            /*$els = array(
                7040 => array(
                    'town' => 'Липецк',
                    'person' => array(
                        14 => array(
                            array(
                                'title' => 'КЦ1',
                                'time' => 'Каждый вторник с 14-00 до 16-00',
                                'where' => 'АБК 1 этаж'),
                            array(
                                'title' => 'ДЦ1',
                                'time' => 'Каждая пятница с 14-00 до 16-00',
                                'where' => 'АБК 1 этаж'),
                            array(
                                'title' => 'Доломит',
                                'time' => '1 и 15 число месяца с 09-00 до 12-00',
                                'where' => 'Библиотека (3 этаж)'),
                            array(
                                'title' => 'ЦМК',
                                'time' => 'Четверг (2й и 4й) с 12-00 до 14-00',
                                'where' => 'Рядом со столовой'),
                            array(
                                'title' => 'Газовый цех',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'МЦСО1',
                                'time' => 'Каждый вторник с 14-00 до 16-00',
                                'where' => 'АБК КЦ1 (1 этаж)'),
                        ),
                        9 => array(
                            array(
                                'title' => 'ЦХПП',
                                'time' => 'Каждый понедельник с 11-30 до 13-15',
                                'where' => 'АБК '),
                            array(
                                'title' => 'ОГЦ',
                                'time' => 'Каждый вторник с 09-00 до 11-00',
                                'where' => 'АБК '),
                        ),
                        10 => array(
                            array(
                                'title' => 'УЖДТ',
                                'time' => 'Каждый третий понедельник с 11-00 до 12-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'НЛМК Инжиниринг',
                                'time' => 'Последняя пятница месяца с 12-00 до 13-00',
                                'where' => 'Кабинет ИТ'),
                            array(
                                'title' => 'ЦПМШ+ЦЖБИ',
                                'time' => 'ЦПМШ (каждое 9 число месяца); ЦЖБИ (каждое 21 число месяца)',
                                'where' => '08-30 до 09-30 '),
                        ),
                        12 => array(
                            array(
                                'title' => 'Капровый цех',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'Автотранспортное управление',
                                'time' => 'Каждый понедельник с 16-30 по 18-00',
                                'where' => 'Диспетчерская'),
                            array(
                                'title' => 'Фасонолитейный цех',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                        ),
                        11 => array(
                            array(
                                'title' => 'Агломерационный цех',
                                'time' => 'Каждый четверг с 14-30 до 16-00',
                                'where' => 'АБК с банкоматом'),
                            array(
                                'title' => 'ДЦ2',
                                'time' => '',
                                'where' => 'При необходимости, на время ремонта основного АБК, консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'Ферросплавный цех',
                                'time' => '2й и 4й понедельник с 08-00 до 10-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'КЦ2',
                                'time' => 'Каждый вторник с 14-00 до 16-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'Новолипецкий печатный дом',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'ГК Металлург',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                        ),
                        13 => array(
                            array(
                                'title' => 'НЛМК ИТ/НЛМК Связь',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'ЦВС',
                                'time' => '15 числа каждого месяца',
                                'where' => 'АБК'),
                            array(
                                'title' => 'Кислородный цех',
                                'time' => 'Каждый 2й и 3й четверг с 15-30 до 17-00',
                                'where' => 'АБК КО2'),
                            array(
                                'title' => 'ТЭЦ',
                                'time' => 'Каждый 1й и 4й четверг с 11-00 до 12-30',
                                'where' => 'АБК 4 этаж'),
                            array(
                                'title' => 'МЦСО2',
                                'time' => '2 и 3 среда с 14-00 до 15-30',
                                'where' => 'АБК'),
                            array(
                                'title' => 'Стагдок',
                                'time' => 'Каждое 19ое и 24ое число с 11-15 до 13-15',
                                'where' => 'АБК 1 этаж, рядом с банкоматом'),
                        ),
                        15 => array(
                            array(
                                'title' => 'Цех подготовки производства',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'Газбетон48',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'Цех Трансформаторной стали',
                                'time' => 'Каждая среда с 11-00 до 13-00',
                                'where' => 'АБК (3 этаж)'),
                            array(
                                'title' => 'Цех динамной стали',
                                'time' => 'Каждая пятница с 12-00 до 14-00',
                                'where' => 'АБК (1 этаж)'),
                            array(
                                'title' => 'Ремонтное управление ДРК',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'Новолипецкая Металлобаза',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                        ),
                        16 => array(
                            array(
                                'title' => 'МЦПО',
                                'time' => 'Каждая 2 и 4 среда с 14-00 до 16-00',
                                'where' => 'АБК, 3 этаж '),
                            array(
                                'title' => 'Цех горячего проката',
                                'time' => 'Каждый четверг с 11-00 до 13-00',
                                'where' => '2 этаж перед столовой'),
                            array(
                                'title' => 'Коксохимический цех',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'НЛМК Учетный центр',
                                'time' => '22 число с 14-00',
                                'where' => '1 этаж'),
                        )
                    ),
                ),
                7044 => array(
                    'town' => 'Старый Оскол',
                    'person' => array(
                        17 => array(
                            array(
                                'title' => 'Рудоуправление',
                                'time' => 'Каждая пятница с 08-00 до 10-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'АТЦ',
                                'time' => 'Каждая среда с 08-00 до 10-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'ЦХХ',
                                'time' => 'Второй и четвертый четверг месяца с 13-00 до 14-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'РК',
                                'time' => 'Второй и четвертый вторник месяца с 08-00 до 10-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'Медсанчасть',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                        ),
                        18 => array(
                            array(
                                'title' => 'ЦЖДТ',
                                'time' => 'Каждая пятница с 08-00 до 09-00',
                                'where' => 'АБК'),
                            array(
                                'title' => 'Дренажная шахта',
                                'time' => '',
                                'where' => 'При необходимости консультации звоните на мобильный номер закрепленному менеджеру'),
                            array(
                                'title' => 'ЦСП',
                                'time' => 'Каждый вторник с 07-50 до 09-00',
                                'where' => '2 этаж конференц зал'),
                            array(
                                'title' => 'ФОК',
                                'time' => 'Каждый четверг с ',
                                'where' => '1 этаж, у банкомата'),
                            array(
                                'title' => 'ОФ',
                                'time' => 'каждая среда с 08-30 до 09-30',
                                'where' => '1 этаж у банкомата'),
                        )
                    ),
                ),
            );
            foreach ($els as $cat_id => $params) {
                foreach ($params['person'] as $pers_id => $person) {
                    foreach ($person as $location) {
                        $location_id = sql_assoc('SELECT s.s_id as id FROM sb_sprav s INNER JOIN sb_catlinks l ON s.s_id = l.link_el_id WHERE s.s_title LIKE "'.$location['title'].'" AND l.link_cat_id = 7038 ');
                        if ($location_id) {
                            $location_id = $location_id[0]['id'];
                            $row = array(
                                'p_title' => $location['title'],
                                'p_url' => sb_check_chpu('0', '', $location['title'], 'sb_plugins_129', 'p_url', 'p_id'),
                                'p_active' => 1,
                                'user_f_1' => $params['town'],
                                'user_f_2' => $pers_id,
                                'user_f_4' => $location_id,
                                'user_f_5' => '',
                                'user_f_6' => $location['time'],
                                'user_f_7' => $location['where'],
                            );
                            sbProgAddElement('sb_plugins_129', 'p_id', $row, array($cat_id));
                        } else echo 'Нет локации с названием "'.$location['title'].'"<br>';
                    }
                }
            }*/

            // Записываю новые email в города (элементы справочников)
            /*$emails = array(
                630305 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630513 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630306 => 'Nailya.Khakimova@rosbank.ru,Mariya.Arkhipova@rosbank.ru',
                630514 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630515 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630307 => 'Anna.Ananeva@rosbank.ru,Ekaterina.Shestakova@rosbank.ru',
                630310 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630311 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630312 => 'ovmashkova@ast.rosbank.ru,YVKostina@ast.rosbank.ru,Elena.Novikova@rosbank.ru',
                630313 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630314 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630316 => 'SKotlar@alt.rosbank.ru,Elena.Kovkina@rosbank.ru',
                630318 => 'Irina.Gorbatenko@rosbank.ru,SAParfenov@orel.rosbank.ru',
                630516 => 'Inna.Dyukova@rosbank.ru,Elvira.Dmitrieva@rosbank.ru',
                630517 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630573 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630321 => 'SKotlar@alt.rosbank.ru,Elena.Kovkina@rosbank.ru',
                630518 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630322 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630519 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630324 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630520 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630325 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630326 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630328 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630329 => 'DAKrivosheev@volg.rosbank.ru,Maksim.Cheshev@rosbank.ru',
                630331 => 'DAKrivosheev@volg.rosbank.ru,Maksim.Cheshev@rosbank.ru',
                630332 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630521 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630333 => 'Denis.Polyakov@rosbank.ru,EVSazonova@tambov.rosbank.ru,Igor.Khorokhordin@rosbank.ru',
                630522 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630523 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630524 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630336 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630339 => 'Pavel.Kurakin@rosbank.ru',
                630525 => 'Pavel.Kurakin@rosbank.ru',
                630526 => 'Larisa.Sabanina@rosbank.ru,IAChesnokova@norilsk.rosbank.ru',
                630341 => 'indira.bachinina@rosbank.ru,Lyubov.Batyrova@rosbank.ru',
                630342 => 'Denis.Polyakov@rosbank.ru,EVSazonova@tambov.rosbank.ru,Igor.Khorokhordin@rosbank.ru',
                630527 => 'Tatyana.Pernikova@rosbank.ru,NABragina@kam.rosbank.ru,Yaroslav.Basenko@rosbank.ru',
                630528 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630344 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630530 => 'Pavel.Kurakin@rosbank.ru',
                630529 => 'Roman.Miroshchev@rosbank.ru',
                630531 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630532 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630533 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630534 => 'Pavel.Kurakin@rosbank.ru',
                630535 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630536 => 'Marianna.Zhdanova@rosbank.ru,NAChirikova@tomskreg.rosbank.ru',
                630347 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630348 => 'Nina.Petrova@rosbank.ru,Olga.Chetina@rosbank.ru,NVAlekseev@udmur.rosbank.ru;',
                630350 => 'Nailya.Khakimova@rosbank.ru,Mariya.Arkhipova@rosbank.ru',
                630349 => 'Anna.Ananeva@rosbank.ru,Ekaterina.Shestakova@rosbank.ru',
                630537 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630351 => 'Nailya.Khakimova@rosbank.ru,Mariya.Arkhipova@rosbank.ru',
                630352 => 'Irina.Avdoshina@rosbank.ru,Zhannet.Pi.Vargas@rosbank.ru,EVShimanskaya@kalin.rosbank.ru',
                630353 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630538 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630357 => 'Inna.Dyukova@rosbank.ru,Elvira.Dmitrieva@rosbank.ru',
                630359 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630539 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630361 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630540 => 'Marianna.Zhdanova@rosbank.ru,NAChirikova@tomskreg.rosbank.ru',
                630362 => 'Pavel.Kurakin@rosbank.ru',
                630363 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630365 => 'Pavel.Kurakin@rosbank.ru',
                630366 => 'Aleksey.Nazanskiy@rosbank.ru,Svetlana.Semicheva@rosbank.ru',
                630367 => 'Pavel.Kurakin@rosbank.ru',
                630368 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630541 => 'AVUshakova@chit.rosbank.ru,AAUvarova@chit.rosbank.ru',
                630369 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630542 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630543 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630370 => 'Tatyana.Galieva@rosbank.ru,Dmitriy.Bolshchikov@rosbank.ru,Oksana.Meshkova@rosbank.ru,Mayya.Vasileva@rosbank.ru',
                630371 => 'Irina.Gorbatenko@rosbank.ru,SAParfenov@orel.rosbank.ru',
                630372 => 'Vitaliy.Danilov@rosbank.ru,stovuu@tuva.rosbank.ru',
                630544 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630545 => 'Inna.Dyukova@rosbank.ru,Elvira.Dmitrieva@rosbank.ru',
                630546 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630547 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630373 => 'Denis.Polyakov@rosbank.ru,EVSazonova@tambov.rosbank.ru,Igor.Khorokhordin@rosbank.ru',
                630548 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630549 => 'Boris.Korolev@rosbank.ru,olesya.shayakhmetova@rosbank.ru',
                630375 => 'Tatyana.Galieva@rosbank.ru,Dmitriy.Bolshchikov@rosbank.ru,Oksana.Meshkova@rosbank.ru,Mayya.Vasileva@rosbank.ru',
                630550 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630551 => 'Marianna.Zhdanova@rosbank.ru,NAChirikova@tomskreg.rosbank.ru',
                630552 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630553 => 'Boris.Korolev@rosbank.ru,olesya.shayakhmetova@rosbank.ru',
                630554 => 'Denis.Polyakov@rosbank.ru,EVSazonova@tambov.rosbank.ru,Igor.Khorokhordin@rosbank.ru',
                630555 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630379 => 'Elena.Povarova@rosbank.ru,Roman.Kakashinskiy@rosbank.ru,Roman.Miroshchev@rosbank.ru',
                630380 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630381 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630382 => 'Pavel.Kurakin@rosbank.ru',
                630383 => 'Nailya.Khakimova@rosbank.ru,Mariya.Arkhipova@rosbank.ru',
                630556 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630386 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630557 => 'Boris.Korolev@rosbank.ru,olesya.shayakhmetova@rosbank.ru',
                630389 => 'Marina.Prokoptseva@rosbank.ru,Anastasiya.Usoltseva@rosbank.ru',
                630558 => 'Boris.Korolev@rosbank.ru,olesya.shayakhmetova@rosbank.ru',
                630392 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630393 => 'indira.bachinina@rosbank.ru,Lyubov.Batyrova@rosbank.ru',
                630559 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630394 => 'Inna.Dyukova@rosbank.ru,Elvira.Dmitrieva@rosbank.ru',
                630396 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630397 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630560 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630398 => 'Aleksandr.Mashkov@rosbank.ru,Bator.Baldorzhiev@rosbank.ru',
                630403 => 'Pavel.Kurakin@rosbank.ru',
                630404 => 'Larisa.Sabanina@rosbank.ru,IAChesnokova@norilsk.rosbank.ru',
                630406 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630407 => 'Pavel.Kurakin@rosbank.ru',
                630408 => 'Irina.Masachuk@rosbank.ru,AMFatkullina@ufa.rosbank.ru',
                630409 => 'Olga.Alert@rosbank.ru,Ekaterina.Maslakova@rosbank.ru,Aleksandr.Dolmatov@rosbank.ru',
                630410 => 'Irina.Gorbatenko@rosbank.ru,SAParfenov@orel.rosbank.ru',
                630411 => 'elena.sychyova@rosbank.ru,Yuliya.Snopkova@rosbank.ru,Aleksey.Dubrovin@rosbank.ru',
                630412 => 'Pavel.Kurakin@rosbank.ru',
                630561 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630414 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630562 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630416 => 'Nina.Petrova@rosbank.ru,Olga.Chetina@rosbank.ru,NVAlekseev@udmur.rosbank.ru;',
                630417 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630418 => 'Tatyana.Pernikova@rosbank.ru,NABragina@kam.rosbank.ru,Yaroslav.Basenko@rosbank.ru',
                630419 => 'Pavel.Kurakin@rosbank.ru',
                630421 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630423 => 'Olesya.Alferova@rosbank.ru,ozinoviev@stav.rosbank.ru,ALobov@rostov.rosbank.ru,Artur.Shiroyan@rosbank.ru',
                630563 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630424 => 'Pavel.Kurakin@rosbank.ru',
                630564 => 'Pavel.Kurakin@rosbank.ru',
                630425 => 'Olesya.Alferova@rosbank.ru,ozinoviev@stav.rosbank.ru,ALobov@rostov.rosbank.ru,Artur.Shiroyan@rosbank.ru',
                630427 => 'Aleksey.Nazanskiy@rosbank.ru,Svetlana.Semicheva@rosbank.ru',
                630428 => 'Pavel.Bocharov@rosbank.ru,Evgeniya.Lopatkina@rosbank.ru',
                630430 => 'elena.sychyova@rosbank.ru,Yuliya.Snopkova@rosbank.ru,Aleksey.Dubrovin@rosbank.ru',
                630431 => 'Yuriy.V.Smirnov@rosbank.ru,ENikolaeva@szap.rosbank.ru,Natalya.Matyunina@rosbank.ru,Melina.Danielyan@rosbank.ru,Ekaterina.Malygina@rosbank.ru',
                630432 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630433 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630565 => 'Anna.Shumkova@rosbank.ru,Tatyana.Buntina@rosbank.ru,Yana.Loseva@rosbank.ru',
                630566 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630435 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630436 => 'Marianna.Zhdanova@rosbank.ru,NAChirikova@tomskreg.rosbank.ru',
                630567 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630440 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630441 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630442 => 'Olesya.Alferova@rosbank.ru,ozinoviev@stav.rosbank.ru,ALobov@rostov.rosbank.ru,Artur.Shiroyan@rosbank.ru',
                630443 => 'Irina.Gorbatenko@rosbank.ru,SAParfenov@orel.rosbank.ru',
                630444 => 'Irina.Masachuk@rosbank.ru,AMFatkullina@ufa.rosbank.ru',
                630445 => 'Marina.Prokoptseva@rosbank.ru,Anastasiya.Usoltseva@rosbank.ru',
                630446 => 'elena.sychyova@rosbank.ru,Yuliya.Snopkova@rosbank.ru,Aleksey.Dubrovin@rosbank.ru',
                630447 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630449 => 'Denis.Polyakov@rosbank.ru,EVSazonova@tambov.rosbank.ru,Igor.Khorokhordin@rosbank.ru',
                630450 => 'Aleksey.Nazanskiy@rosbank.ru,Svetlana.Semicheva@rosbank.ru',
                630568 => 'Marina.Prokoptseva@rosbank.ru,Anastasiya.Usoltseva@rosbank.ru',
                630451 => 'elena.sychyova@rosbank.ru,Yuliya.Snopkova@rosbank.ru,Aleksey.Dubrovin@rosbank.ru',
                630452 => 'Marianna.Zhdanova@rosbank.ru,NAChirikova@tomskreg.rosbank.ru',
                630569 => 'Kristina.Naumets@rosbank.ru,Yuliya.Polyumberskaya@rosbank.ru,Ruslan.Chigirinov@rosbank.ru',
                630453 => 'Olga.Strelnikova@rosbank.ru,EIAnchishina@kaluga.rosbank.ru',
                630570 => 'TBLegkikh@amur.rosbank.ru,evbabay@amur.rosbank.ru',
                630454 => 'Marina.Prokoptseva@rosbank.ru,Anastasiya.Usoltseva@rosbank.ru',
                630455 => 'Anton.Protasov@rosbank.ru,SBTsyrenov@ulan.rosbank.ru',
                630456 => 'elena.sychyova@rosbank.ru,Yuliya.Snopkova@rosbank.ru,Aleksey.Dubrovin@rosbank.ru',
                630571 => 'Pavel.Kurakin@rosbank.ru',
                630457 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630458 => 'Irina.Masachuk@rosbank.ru,AMFatkullina@ufa.rosbank.ru',
                630459 => 'dmitriy.podoynitsyn@rosbank.ru,YAFilyutina@dal.rosbank.ru',
                630462 => 'Marina.Rizen@rosbank.ru,Maksim.Kozmin@rosbank.ru,Anton.Snegirev@rosbank.ru',
                630463 => 'Tatyana.Galieva@rosbank.ru,Dmitriy.Bolshchikov@rosbank.ru,Oksana.Meshkova@rosbank.ru,Mayya.Vasileva@rosbank.ru',
                630464 => 'Ulyana.Novozhilova@rosbank.ru,Mariya.Shevel@rosbank.ru,Yuliya.Leonteva@rosbank.ru',
                630572 => 'Oksana.Akenina@rosbank.ru,Kseniya.Anishchenko@rosbank.ru',
                630466 => 'AVUshakova@chit.rosbank.ru,AAUvarova@chit.rosbank.ru',
                630468 => 'Pavel.Kurakin@rosbank.ru',
                630470 => 'ovmashkova@ast.rosbank.ru,YVKostina@ast.rosbank.ru,Elena.Novikova@rosbank.ru',
                630471 => 'Darya.Efimova@rosbank.ru,Olga.Mashkova@rosbank.ru,denis.valov@rosbank.ru ,LAPodstavina@saratov.rosbank.ru',
                630472 => 'Anastasiya.Nam@rosbank.ru,Antonina.Zhuykova@rosbank.ru',
                630473 => 'Boris.Korolev@rosbank.ru,olesya.shayakhmetova@rosbank.ru',
                630474 => 'Aleksey.Nazanskiy@rosbank.ru,Svetlana.Semicheva@rosbank.ru'
            );
            foreach ($emails as $id => $email) {
                sql_query('UPDATE sb_sprav SET s_prop2=? WHERE s_id=?d', $email, (int)$id);
            }*/

            // Проверка не серриализованных данных в таблице
            /*$res = sql_query('SELECT s_setting, s_value, s_domain FROM sb_settings');
            if ($res)
            {
                foreach ($res as $value)
                {
                    list($s_setting, $s_value, $s_domain) = $value;

                    if ($s_value != '')
                        if (unserialize($s_value) === false) echo $s_setting.' '.$s_value.' '.$s_domain, '<br>';

                }
            }
            unset($res);*/

            // Тест копирования файла https://cabinet.rshb.ru/yandex/ATM_RSHB.xml
            /*$url = 'https://cabinet.rshb.ru/yandex/ATM_RSHB.xml';
            $filename = '/upload/import/atms_rshb_.xml';

            $curl = curl_init();

            unlink(SB_BASEDIR.$filename);
            $file = fopen(SB_BASEDIR.$filename, 'w');

            phpinfo();
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_PORT, 443);
            curl_setopt($curl, CURLOPT_FILE, $file);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, '60');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($curl, CURLOPT_SSLVERSION, 1);
            //curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');
            //curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cabinet.rshb.ru.crt');
            //curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_VERBOSE, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($curl, CURLOPT_NOBODY, true);
            //curl_setopt($curl, CURLOPT_HEADER, true);
            //curl_setopt($curl, CURLOPT_USERAGENT, 'PHP');


            $result = curl_exec($curl);
            dbg(curl_getinfo($curl), false);
            dbg(curl_error($curl), false);
            curl_close($curl);
            fclose($file);
            dbg($result);*/

            // Акция публикуется только 13.09.2017. Новую акцию записывать в этот блок и поменять дату
            /*$day = 31; // день показа акции
            $month = 9; // месяц
            $year = 2017; // год
            //echo date("H:i:s d-m-Y",mktime(0, 0, 0, $month, $day, $year));
            //$str = 'Тестер';
            // Нахожу раздел элемента
            //$query = 'SELECT cat_id, cat_ident, cat_title FROM sb_categs WHERE cat_ident LIKE "pl_plugin_%" AND (cat_title LIKE "%Карты%" OR cat_title LIKE "%Бизнес-Адвокат%" OR cat_title LIKE "%Бизнес%" OR cat_title LIKE "%Адвокат%")';
            //$query = 'SELECT COLUMN_NAME, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "sb_plugins_116" AND table_schema = "rosbank_new"';
            //$temp_id = 214; // идентификатор макета
            // находим связанный элемент макета с тэгом {FOOTER}
            $citys = array(
                array('title' => 'Абакан', 'prop1' => 'Республика Хакасия'),
                array('title' => 'Альметьевск', 'prop1' => 'Республика Татарстан'),
                array('title' => 'Ангарск', 'prop1' => 'Иркутская область'),
                array('title' => 'Арзамас', 'prop1' => 'Нижегородская обл.'),
                array('title' => 'Армавир', 'prop1' => 'Краснодарский край'),
                array('title' => 'Артем', 'prop1' => 'Приморский край'),
                array('title' => 'Архангельск', 'prop1' => 'Архангельская область'),
                array('title' => 'Астрахань', 'prop1' => 'Астраханская область'),
                array('title' => 'Ачинск', 'prop1' => 'Красноярский край'),
                array('title' => 'Балаково', 'prop1' => 'Саратовская область'),
                array('title' => 'Балашиха', 'prop1' => 'Московская область'),
                array('title' => 'Барнаул', 'prop1' => 'Алтайский край'),
                array('title' => 'Батайск', 'prop1' => 'Ростовская область'),
                array('title' => 'Белгород', 'prop1' => 'Белгородская область'),
                array('title' => 'Бердск', 'prop1' => 'Новосибирская обл.'),
                array('title' => 'Березники', 'prop1' => 'Пермский край'),
                array('title' => 'Бийск', 'prop1' => 'Алтайский край'),
                array('title' => 'Благовещенск', 'prop1' => 'Амурская область'),
                array('title' => 'Братск', 'prop1' => 'Иркутская область'),
                array('title' => 'Брянск', 'prop1' => 'Брянская область'),
                array('title' => 'Великий Новгород', 'prop1' => 'Новгородская обл.'),
                array('title' => 'Владивосток', 'prop1' => 'Приморский край'),
                array('title' => 'Владикавказ', 'prop1' => 'Респ. Северная Осетия-Алания'),
                array('title' => 'Владимир', 'prop1' => 'Владимирская область'),
                array('title' => 'Волгоград', 'prop1' => 'Волгоградская область'),
                array('title' => 'Волгодонск', 'prop1' => 'Ростовская область'),
                array('title' => 'Волжский', 'prop1' => 'Волгоградская область'),
                array('title' => 'Вологда', 'prop1' => 'Вологодская область'),
                array('title' => 'Воронеж', 'prop1' => 'Воронежская область'),
                array('title' => 'Грозный', 'prop1' => 'Чеченская Республика'),
                array('title' => 'Дербент', 'prop1' => 'Республика Дагестан'),
                array('title' => 'Дзержинск', 'prop1' => 'Нижегородская обл.'),
                array('title' => 'Димитровград', 'prop1' => 'Ульяновская область'),
                array('title' => 'Долгопрудный', 'prop1' => 'Московская область'),
                array('title' => 'Домодедово', 'prop1' => 'Московская область'),
                array('title' => 'Евпатория', 'prop1' => 'Республика Крым'),
                array('title' => 'Екатеринбург', 'prop1' => 'Свердловская область'),
                array('title' => 'Елец', 'prop1' => 'Липецкая область'),
                array('title' => 'Ессентуки', 'prop1' => 'Ставропольский край'),
                array('title' => 'Железногорск', 'prop1' => 'Курская область'),
                array('title' => 'Жуковский', 'prop1' => 'Московская область'),
                array('title' => 'Златоуст', 'prop1' => 'Челябинская область'),
                array('title' => 'Иваново', 'prop1' => 'Ивановская область'),
                array('title' => 'Ижевск', 'prop1' => 'Удмуртская Респ.'),
                array('title' => 'Иркутск', 'prop1' => 'Иркутская область'),
                array('title' => 'Йошкар-Ола', 'prop1' => 'Республика Марий Эл'),
                array('title' => 'Казань', 'prop1' => 'Республика Татарстан'),
                array('title' => 'Калининград', 'prop1' => 'Калининградская обл.'),
                array('title' => 'Калуга', 'prop1' => 'Калужская область'),
                array('title' => 'Каменск - Уральский', 'prop1' => 'Свердловская область'),
                array('title' => 'Камышин', 'prop1' => 'Волгоградская область'),
                array('title' => 'Каспийск', 'prop1' => 'Республика Дагестан'),
                array('title' => 'Кемерово', 'prop1' => 'Кемеровская область'),
                array('title' => 'Керчь', 'prop1' => 'Республика Крым'),
                array('title' => 'Киров', 'prop1' => 'Кировская область'),
                array('title' => 'Кисловодск', 'prop1' => 'Ставропольский край'),
                array('title' => 'Ковров', 'prop1' => 'Владимирская область'),
                array('title' => 'Коломна', 'prop1' => 'Московская область'),
                array('title' => 'Комсомольск-на-Амуре', 'prop1' => 'Хабаровский край'),
                array('title' => 'Копейск', 'prop1' => 'Челябинская область'),
                array('title' => 'Королёв', 'prop1' => 'Московская область'),
                array('title' => 'Кострома', 'prop1' => 'Костромская область'),
                array('title' => 'Красногорск', 'prop1' => 'Московская область'),
                array('title' => 'Краснодар', 'prop1' => 'Краснодарский край'),
                array('title' => 'Красноярск', 'prop1' => 'Красноярский край'),
                array('title' => 'Курган', 'prop1' => 'Курганская область'),
                array('title' => 'Курск', 'prop1' => 'Курская область'),
                array('title' => 'Кызыл', 'prop1' => 'Республика Тыва'),
                array('title' => 'Липецк', 'prop1' => 'Липецкая область'),
                array('title' => 'Люберцы', 'prop1' => 'Московская область'),
                array('title' => 'Магнитогорск', 'prop1' => 'Челябинская область'),
                array('title' => 'Майкоп', 'prop1' => 'Республика Адыгея'),
                array('title' => 'Махачкала', 'prop1' => 'Республика Дагестан'),
                array('title' => 'Миасс', 'prop1' => 'Челябинская область'),
                array('title' => 'Москва', 'prop1' => 'г. Москва'),
                array('title' => 'Мурманск', 'prop1' => 'Мурманская область'),
                array('title' => 'Муром', 'prop1' => 'Владимирская область'),
                array('title' => 'Мытищи', 'prop1' => 'Московская область'),
                array('title' => 'Набережные Челны', 'prop1' => 'Республика Татарстан'),
                array('title' => 'Назрань', 'prop1' => 'Республика Ингушетия'),
                array('title' => 'Нальчик', 'prop1' => 'Кабардино-Балкарская Респ.'),
                array('title' => 'Находка', 'prop1' => 'Приморский край'),
                array('title' => 'Невинномысск', 'prop1' => 'Ставропольский край'),
                array('title' => 'Нефтекамск', 'prop1' => 'Респ. Башкортостан'),
                array('title' => 'Нефтеюганск', 'prop1' => 'Ханты-Мансийский АО'),
                array('title' => 'Нижневартовск', 'prop1' => 'Ханты-Мансийский АО'),
                array('title' => 'Нижнекамск', 'prop1' => 'Республика Татарстан'),
                array('title' => 'Нижний Новгород', 'prop1' => 'Нижегородская обл.'),
                array('title' => 'Нижний Тагил', 'prop1' => 'Свердловская область'),
                array('title' => 'Новокузнецк', 'prop1' => 'Кемеровская область'),
                array('title' => 'Новокуйбышевск', 'prop1' => 'Самарская область'),
                array('title' => 'Новомосковск', 'prop1' => 'Тульская область'),
                array('title' => 'Новороссийск', 'prop1' => 'Краснодарский край'),
                array('title' => 'Новосибирск', 'prop1' => 'Новосибирская обл.'),
                array('title' => 'Новочебоксарск', 'prop1' => 'Чувашская Республика'),
                array('title' => 'Новочеркасск', 'prop1' => 'Ростовская область'),
                array('title' => 'Новошахтинск', 'prop1' => 'Ростовская область'),
                array('title' => 'Новый Уренгой', 'prop1' => 'Ямало-Ненецкий АО'),
                array('title' => 'Ногинск', 'prop1' => 'Московская область'),
                array('title' => 'Норильск', 'prop1' => 'Красноярский край'),
                array('title' => 'Ноябрьск', 'prop1' => 'Ямало-Ненецкий АО'),
                array('title' => 'Обнинск', 'prop1' => 'Калужская область'),
                array('title' => 'Одинцово', 'prop1' => 'Московская область'),
                array('title' => 'Октябрьский', 'prop1' => 'Респ. Башкортостан'),
                array('title' => 'Омск', 'prop1' => 'Омская область'),
                array('title' => 'Орёл', 'prop1' => 'Орловская область'),
                array('title' => 'Оренбург', 'prop1' => 'Оренбургская область'),
                array('title' => 'Орехово-Зуево', 'prop1' => 'Московская область'),
                array('title' => 'Орск', 'prop1' => 'Оренбургская область'),
                array('title' => 'Пенза', 'prop1' => 'Пензенская область'),
                array('title' => 'Первоуральск', 'prop1' => 'Свердловская область'),
                array('title' => 'Пермь', 'prop1' => 'Пермский край'),
                array('title' => 'Петрозаводск', 'prop1' => 'Республика Карелия'),
                array('title' => 'Петропавловск-Камчатский', 'prop1' => 'Камчатский край'),
                array('title' => 'Подольск', 'prop1' => 'Московская область'),
                array('title' => 'Прокопьевск', 'prop1' => 'Кемеровская область'),
                array('title' => 'Псков', 'prop1' => 'Псковская область'),
                array('title' => 'Пушкино', 'prop1' => 'Московская область'),
                array('title' => 'Пятигорск', 'prop1' => 'Ставропольский край'),
                array('title' => 'Раменское', 'prop1' => 'Московская область'),
                array('title' => 'Ростов-на-Дону', 'prop1' => 'Ростовская область'),
                array('title' => 'Рубцовск', 'prop1' => 'Алтайский край'),
                array('title' => 'Рыбинск', 'prop1' => 'Ярославская область'),
                array('title' => 'Рязань', 'prop1' => 'Рязанская область'),
                array('title' => 'Салават', 'prop1' => 'Респ. Башкортостан'),
                array('title' => 'Самара', 'prop1' => 'Самарская область'),
                array('title' => 'Санкт-Петербург', 'prop1' => 'г. Санкт-Петербург'),
                array('title' => 'Саранск', 'prop1' => 'Республика Мордовия'),
                array('title' => 'Саратов', 'prop1' => 'Саратовская область'),
                array('title' => 'Севастополь', 'prop1' => 'Г. Севастополь'),
                array('title' => 'Северодвинск', 'prop1' => 'Архангельская область'),
                array('title' => 'Северск', 'prop1' => 'Томская область'),
                array('title' => 'Сергиев Посад', 'prop1' => 'Московская область'),
                array('title' => 'Серпухов', 'prop1' => 'Московская область'),
                array('title' => 'Симферополь', 'prop1' => 'Республика Крым'),
                array('title' => 'Смоленск', 'prop1' => 'Смоленская область'),
                array('title' => 'Сочи', 'prop1' => 'Краснодарский край'),
                array('title' => 'Ставрополь', 'prop1' => 'Ставропольский край'),
                array('title' => 'Старый Оскол', 'prop1' => 'Белгородская область'),
                array('title' => 'Стерлитамак', 'prop1' => 'Респ. Башкортостан'),
                array('title' => 'Сургут', 'prop1' => 'Ханты-Мансийский АО'),
                array('title' => 'Сызрань', 'prop1' => 'Самарская область'),
                array('title' => 'Сыктывкар', 'prop1' => 'Республика Коми'),
                array('title' => 'Таганрог', 'prop1' => 'Ростовская область'),
                array('title' => 'Тамбов', 'prop1' => 'Тамбовская область'),
                array('title' => 'Тверь', 'prop1' => 'Тверская область'),
                array('title' => 'Тольятти', 'prop1' => 'Самарская область'),
                array('title' => 'Томск', 'prop1' => 'Томская область'),
                array('title' => 'Тула', 'prop1' => 'Тульская область'),
                array('title' => 'Тюмень', 'prop1' => 'Тюменская область'),
                array('title' => 'Улан - Удэ', 'prop1' => 'Республика Бурятия'),
                array('title' => 'Ульяновск', 'prop1' => 'Ульяновская область'),
                array('title' => 'Уссурийск', 'prop1' => 'Приморский край'),
                array('title' => 'Уфа', 'prop1' => 'Республика Башкортостан'),
                array('title' => 'Хабаровск', 'prop1' => 'Хабаровский край'),
                array('title' => 'Хасавюрт', 'prop1' => 'Республика Дагестан'),
                array('title' => 'Химки', 'prop1' => 'Московская область'),
                array('title' => 'Чебоксары', 'prop1' => 'Чувашская Республика'),
                array('title' => 'Челябинск', 'prop1' => 'Челябинская область'),
                array('title' => 'Череповец', 'prop1' => 'Вологодская область'),
                array('title' => 'Черкесск', 'prop1' => 'Карачаево-Черкесская Респ.'),
                array('title' => 'Чита', 'prop1' => 'Забайкальский край'),
                array('title' => 'Шахты', 'prop1' => 'Ростовская область'),
                array('title' => 'Щёлково', 'prop1' => 'Московская область'),
                array('title' => 'Электросталь', 'prop1' => 'Московская область'),
                array('title' => 'Элиста', 'prop1' => 'Республика Калмыкия'),
                array('title' => 'Энгельс', 'prop1' => 'Саратовская область'),
                array('title' => 'Южно-Сахалинск', 'prop1' => 'Сахалинская область'),
                array('title' => 'Якутск', 'prop1' => 'Респ. Саха (Якутия)'),
                array('title' => 'Ярославль', 'prop1' => 'Ярославская область')
            );
            foreach ($citys as $city) {
                $row=array(
                    's_title'=>$city['title'],
                    's_prop1'=>$city['prop1'],
                    's_active'=>1
                );
                //$id = sbProgAddElement('sb_sprav', 's_id', $row, array(6719));
                if ($id) echo $id.') '.$city['title'].' - '.$city['prop1'];
            }*/

            // добавиляем связи элементов с разделами модуля "Курсы валют для импорта"
            /*// получаем список элементов в таблице sb_plugins_128
            $query = 'SELECT p_id FROM sb_plugins_128 WHERE p_id NOT IN (SELECT link_el_id FROM sb_catlinks WHERE link_cat_id = 6763)';
            $res = sql_assoc($query);
            if ($res) {
                foreach ($res as $row) {
                    $query = 'INSERT INTO sb_catlinks (link_cat_id, link_el_id) VALUES (6763,?d)';
                    sql_assoc($query, $row['p_id']);
                }
            }*/


            // находим страницу с ID 4849 в таблице
            // $query = 'SELECT * FROM sb_elems WHERE e_ident LIKE "pl_pages_page" AND e_link LIKE "page" AND e_p_id = 4849';

            // тест отправки заявок на промокод. Проверяю, имеются ли дубли заявок
            /*$date = mktime(0, 0, 0, sb_date("m"), sb_date("d")-5, sb_date("Y"));
            $query = 'SELECT p.*, cc.change_date
                    FROM sb_plugins_124 p
                    INNER JOIN sb_catchanges cc ON p.p_id = cc.el_id
                    WHERE p.user_f_13 = 0
                    AND cc.cat_ident LIKE "pl_plugin_124"
                    AND cc.action LIKE "add"
                    AND cc.change_date > ?d
                    ORDER BY p.p_id DESC
                    LIMIT 5000';
            $res = sql_assoc($query, $date);*/

            //$res = sql_assoc($query);
            if (isset($res) && $res) {
                //var_dump($res);
                echo count($res);
                echo '<table>';
                foreach ($res as $v) {
                    echo '<tr>';
                    foreach ($v as $n => $f) echo '<td style="color: #c1c1c1;">' . $n . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    foreach ($v as $n => $f) echo '<td>' . $f . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<style>';
                echo 'table td { border: 1px solid}';
                echo '</style>';
            }
            //if (mktime(0, 0, 0, $month, $day, $year) < mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")) && mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")) < mktime(0, 0, 0, $month, $day+1, $year))
        }
        if ($_GET['events'] == 'create_symlink') {
            ?>
            <form method="POST">
                <input type="text" name="target" placeholder="Цель ссылки"
                       value="<?php if (isset($_POST['target'])) echo $_POST['target']; ?>"><br>
                <input type="text" name="link" placeholder="Имя ссылки"
                       value="<?php if (isset($_POST['link'])) echo $_POST['link']; ?>"><br>
                <input type="submit">
            </form>
            <?php

            class createSymlink
            {

                /**
                 * @param string $search_text - искомый текст
                 */
                private $target;
                private $link;

                function __construct($target, $link)
                {
                    $this->target = trim($target);
                    $this->link = trim($link);
                    $this->creat();
                }

                /**
                 * Поиск файла по имени во всех папках и подпапках
                 *
                 * @param string $folderName - пусть до папки
                 */
                public function creat()
                {
                    if (symlink($this->target, $this->link)) echo 'Ссылка создана';
                }
            }

            if (isset($_POST['target']) && isset($_POST['link'])) {
                $cs = new createSymlink($_POST['target'], $_POST['link']);
            }
        }
        if ($_GET['events'] == 'soap_test') {

            //$wsdl = 'https://rosbank.ru/files/wsdl/ATC_CMS_CreateCommunication_Process_PROD_CRM1.WSDL';
            $wsdl = '' . SB_DOMAIN . '/files/wsdl/ATC_CMS_CreateCommunication_Process_PROD_CRM1.txt';
            $content = file_get_contents($wsdl);
            if ($content) echo '<textarea>' . $content . '<textarea>';
            else echo 'Не удалось получить содержимое файла ' . $wsdl . ' функцией file_get_contents().<br>';

            /*class AuthentificationHeader {
                public $username;
                public $password;

                public function __construct($username, $password) {
                    $this->UsernameToken = $username;
                    $this->PasswordText = $password;
                }
            }

            //WSDL
            //    $wsdl='https://rosbank.ru/files/wsdl/ATC_CMS_CreateCommunication_Process_PROD_CRM1.WSDL';
            $wsdl='https://127.0.0.1/files/wsdl/ATC_CMS_CreateCommunication_Process_PROD_CRM1.WSDL';
            $regionText='';
            if (isset($REGIONS[$RegionID])) {$regionText=$REGIONS[$RegionID];}

            $SEND_ARRAY=array('ListOfAtcCmsCreatecommunicationcase'=>array(
            'AtcCommunicationTask'=>array(
                'Product'=>$TopicCode,
                'ApplicationId'=>'{P_ID}',
                'RegTime'=>sb_date('m/d/Y H:i:s'),
                'Source'=>$SourceCode,
                'LastName'=>'{FAMILIYA_45}',
                //'FirstName'=>'{IMYA_44}',
                'FirstName'=>'{KAK_K_VAM_OBRASHATSYA_1}',
                'MiddleName'=>'{OTCHESTVO_46}',
                'BirthDate'=>$birthdatetime,
                'Gender'=>'{POL_72}',
                'Region'=>$regionText,
                'Phone'=>'{TELEFON_3}',
                'CallingTime'=>$datetime,
                'PromoCode'=>'{PROMOKOD_9}',
                'ParamChar1'=>'{GRAZHDANSTVO_37}',
                'ParamChar2'=>'{TIP_ZANYATOSTI_38}',
                'ParamChar3'=>'{RAZMER_DOHODA_40}',
                'ParamChar4'=>'{NALICHIE_TEKUSHEJ_PROSROCHENNOJ_ZADOLZHENNOSTI_PO_KREDITU_41}',
                'ParamChar5'=>'{KOL_VO_KREDITOV_DLYA_REFINANSIROVANIYA_42}',
                'ParamChar6'=>'{SUMMA_VSEH_KREDITOV_DLYA_REFINANSIROVANIYA_43}',
                'ParamChar7'=>'{VOZMOZHNOST_PODTVERZHDENIYA_DOHODA_39}',
                'ParamChar8'=>'{SUMMA_PLATEZHEJ_PO_DRUGIM_KREDITAM_61}',
                'ParamChar9'=>'{STROKA_9_86}',
                'ParamChar10'=>'{STROKA_10_87}',
                'ParamChar11'=>'{STROKA_11_88}',
                'ParamChar12'=>'{STROKA_12_89}',
                'ParamChar13'=>'{STROKA_13_90}',
                'ParamChar14'=>'{STROKA_14_91}',
                'ParamChar15'=>'{STROKA_15_92}',
                'ParamChar16'=>'{STROKA_16_93}',
                'ParamChar17'=>'{STROKA_17_94}',
                'ParamChar18'=>'{STROKA_18_95}',
                'ParamChar19'=>'{STROKA_19_96}',
                'ParamChar20'=>'{STROKA_20_97}',
                'ParamChar21'=>'{STROKA_21_98}',
                'ParamChar22'=>'{STROKA_22_99}',
                'ParamChar23'=>'{STROKA_23_100}',
                'ParamChar24'=>'{STROKA_24_101}',
                'ParamChar25'=>'{STROKA_25_102}',
                'ParamChar26'=>'{STROKA_26_103}',
                'ParamChar27'=>'{STROKA_27_104}',
                'ParamChar28'=>'{STROKA_28_105}',
                'ParamChar29'=>'{STROKA_29_106}',
                'ParamChar30'=>'{STROKA_30_107}'
            )));

            ob_start();
            print_r($SEND_ARRAY['ListOfAtcCmsCreatecommunicationcase']['AtcCommunicationTask']);
            $query=ob_get_clean();
            sql_query('UPDATE sb_plugins_113 SET user_f_18 = ? WHERE p_id = ?', $query, '{P_ID}');*/

        }
        if ($_GET['events'] == 'file_content') {
            ?>
            <form method="POST">
                <input type="text" name="file_path" placeholder="Путь к файлу"
                       value="<?php if (isset($_POST['file_path'])) echo $_POST['file_path']; ?>"
                       style="width: 500px;"><br>
                <input type="text" name="full_file_path" placeholder="Полный путь к файлу"
                       value="<?php if (isset($_POST['full_file_path'])) echo $_POST['full_file_path']; else echo SB_BASEDIR; ?>"
                       style="width: 500px;"><br>
                <input type="submit">
                <input type="submit" name="to_zip" value="Скачать">
            </form>
            <?php

            class SearchContentFile
            {

                /**
                 * @param string $search_text - искомый текст
                 */
                private $file_path;
                private $full_file_path;
                private $to_zip = false;

                function __construct($file_path, $full_file_path, $to_zip = false)
                {
                    $this->file_path = trim($file_path);
                    $this->full_file_path = trim($full_file_path);
                    if ($to_zip) $this->to_zip = true;
                }

                private function perms($filename)
                {
                    return substr(decoct(fileperms($filename)), -3);
                }

                /**
                 * Поиск файла по имени во всех папках и подпапках
                 *
                 * @param string $folderName - пусть до папки
                 */
                public function info()
                {
                    $output = $content = $file = '';

                    if ($this->file_path != '') $file = SB_BASEDIR . $this->file_path;
                    if ($this->full_file_path != '') $file = $this->full_file_path;

                    if (file_exists($file)) {

                        //echo shell_exec('chown -R apache:apache /home/bmwbank/web/bmwbank.ru/public_html/cms/backup/TransferringTables');
                        echo shell_exec('ls -al /home/bmwbank/web/bmwbank.ru/public_html/cms/plugins/own/pl_change_domain/cron');
                        echo '<br>';

                        $content = file_get_contents($file);
                        $output .= '<textarea style="width: 100%; height: 1000px">' . str_replace(array('<', '>'), array('&lt;', '&gt;'), iconv("cp1251", "UTF-8", $content)) . '</textarea>';
                    } else $output .= 'Файла не существует';

                    if ($this->to_zip && $content != '') {
                        $tmp = explode('/', $file);
                        // Создание ZIP-архива
                        $zip = new ZipArchive;
                        $zipfilename = $tmp[count($tmp) - 1] . '.zip';
                        if ($zip->open(SB_BASEDIR . '/system/' . $zipfilename, ZipArchive::CREATE) !== TRUE) {
                            echo 'Невозможно открыть <$zipfilename>';
                        } else $output = 'Скачать файл в zip-архиве <a href="/system/' . $zipfilename . '" target="_blank">' . $zipfilename . '</a><br>';
                        $zip->addFromString($tmp[count($tmp) - 1], $content);
                        $zip->close();
                    }
                    echo $output;
                }
            }

            if (isset($_POST['file_path']) && isset($_POST['full_file_path'])) {
                if (isset($_POST['to_zip'])) $scf = new SearchContentFile($_POST['file_path'], $_POST['full_file_path'], true);
                else $scf = new SearchContentFile($_POST['file_path'], $_POST['full_file_path']);
                $scf->info();
            }
        }
        if ($_GET['events'] == 'page_404') {
            sb_404();
        }
        if ($_GET['events'] == 'exec_moduls') {
            //SCron::fMakeXMLOfModuls();


            //require_once SB_CMS_PL_PATH.'/own/pl_xml_make/pl_xml_make.php';
            //fPromocodeAndCallRequestsXmlMake();
            //fOfficesXmlMake();
            //require_once SB_CMS_PL_PATH.'/own/pl_atms_status/pl_atms_status.php';
            //fNewAtmsStatusCron();
        }
        if ($_GET['events'] == 'search_content_pages') {
            ?>
            <form method="POST">
                <textarea name="page_urls" placeholder="URLs страниц"></textarea><br>
                <input type="text" name="search_text" placeholder="Искомый текст"><br>
                <input type="submit">
            </form>
            <?php

            class SearchContentPages
            {

                /**
                 * @param string $search_text - искомый текст
                 */
                private $search_text;

                /**
                 * @param string $page_urls - Навзание файла
                 */
                private $page_urls;

                /**
                 * @param array $page_contain_text - Список страниц, содержащих текст
                 */
                private $page_contain_text;

                public function __construct($page_urls, $search_text)
                {
                    $this->page_urls = explode("\r\n", $page_urls);
                    $this->search_text = $search_text;
                }

                /**
                 * Поиск файла по имени во всех папках и подпапках
                 *
                 * @param string $folderName - пусть до папки
                 */
                public function info()
                {
                    foreach ($this->page_urls as $url) {
                        $this->search_content($url);
                    }

                    // вывод списков
                    echo '<b>Список файлов, содержащих текст "' . $this->search_text . '":</b>' . '<br>';
                    echo implode('<br>', $this->page_contain_text) . '<br>';
                }

                private function search_content($url)
                {
                    // открываем текущую папку
                    $content = file_get_contents(SB_DOMAIN . $url);
                    if (stripos($content, $this->search_text) != false) $this->page_contain_text[] = SB_DOMAIN . $url;
                }
            }

            $st = new SearchContentPages($_POST['page_urls'], $_POST['search_text']);
            $st->info();
        }
        if ($_GET['events'] == 'search_file') {
            ?>
            <form method="POST">
                <input type="text" name="file_name" placeholder="Навзание файла">
                <input type="text" name="search_text" placeholder="Искомый текст">
                <input type="submit">
            </form>
            <?php

            class SearchFile
            {

                /**
                 * @param string $search_text - искомый текст
                 */
                private $search_text;

                /**
                 * @param string $file_name - Навзание файла
                 */
                private $file_name;

                /**
                 * @param string $folderName - пусть до папки
                 */
                private $folderName;

                // список файлов стилей, использующих файл иконок
                private $contain_text = array();

                public function __construct($file_name = '.php', $search_text)
                {
                    $this->file_name = $file_name;
                    $this->search_text = $search_text;
                }

                /**
                 * Поиск файла по имени во всех папках и подпапках
                 *
                 * @param string $folderName - пусть до папки
                 */
                public function info($folderName = '')
                {
                    if (trim($folderName) == '') $this->folderName = $_SERVER['DOCUMENT_ROOT'];
                    $this->search_file($this->folderName);

                    // вывод списков
                    echo '<b>Список файлов, содержащих текст "' . $this->search_text . '":</b>' . '<br>';
                    echo implode('<br>', $this->contain_text) . '<br>';
                }

                private function search_file($folderName)
                {
                    // открываем текущую папку
                    $dir = opendir($folderName);

                    // перебираем папку
                    while (($file = readdir($dir)) !== false) { // перебираем пока есть файлы
                        if ($file != "." && $file != "..") { // если это не папка
                            if (is_file($folderName . "/" . $file)) { // если файл проверяем имя
                                // если имя файла нужное, то вернем путь до него
                                if (strpos($file, $this->file_name)) {
                                    if ($this->search_text != '') {
                                        $content = file_get_contents($folderName . "/" . $file);
                                        if (strpos($content, $this->search_text) !== false) $this->contain_text[] = str_replace($_SERVER['DOCUMENT_ROOT'], SB_DOMAIN, $folderName . "/" . $file);
                                    } else $this->contain_text[] = str_replace($_SERVER['DOCUMENT_ROOT'], SB_DOMAIN, $folderName . "/" . $file);
                                }
                            }
                            // если папка, то рекурсивно вызываем search_file
                            if (is_dir($folderName . "/" . $file)) $this->search_file($folderName . "/" . $file);
                        }
                    }

                    // закрываем папку
                    closedir($dir);
                }
            }

            $st = new SearchFile($_POST['file_name'], $_POST['search_text']);
            $st->info();
        }
        if ($_GET['events'] == 'page_related_site_layouts') {
            ?>
            <form method="POST">
                <input type="text" name="page_url" placeholder="URL страницы"><br>
                <textarea name="page_urls" placeholder="URLs страниц"></textarea><br>
                <label><input type="checkbox" name="path"
                              value="1" <?php echo (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : ''; ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class TBListRelatedSiteLayouts
            {


                /**
                 * @param array массив ID страниц
                 */
                private $site_layouts_ids;

                /**
                 * @param integer ID макета
                 */
                private $page_urls;

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function layoutURL($urls, $is_string = false)
                {
                    if ($is_string) $this->page_urls = array($urls);
                    else $this->page_urls = explode("\r\n", $urls);
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    foreach ($this->page_urls as $page_url) {
                        $query = 'SELECT e_tag, e_p_id FROM sb_elems WHERE e_ident LIKE "pl_pages_page" AND e_link LIKE "temp" AND e_params LIKE "%' . $page_url . '%"';
                        $site_layouts_ids = sql_assoc($query);
                        if ($site_layouts_ids) {
                            foreach ($site_layouts_ids as $site_layout) {
                                if (!array_key_exists($site_layout['e_p_id'], $this->site_layouts_ids)) $this->site_layouts_ids[$site_layout['e_p_id']] = $site_layout['e_tag'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->site_layouts_ids) && count($this->site_layouts_ids) > 0) {
                        foreach ($this->site_layouts_ids as $site_layouts_id => $tag) {
                            if ($this->path) {
                                $cat_ids = sql_assoc('SELECT l.link_cat_id FROM sb_templates t LEFT JOIN sb_catlinks l ON t.t_id = l.link_el_id WHERE t.t_id = ?d', intval($site_layouts_id));
                                $cats = array();
                                if ($cat_ids) foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                                $query = 'SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_templates" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC';
                                $cats = sql_assoc($query);
                                //var_dump($cats);
                                if ($cats) {
                                    echo '<div> Tag: ' . $tag . '</div>';
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $site_layout = sql_assoc('SELECT t_name FROM sb_templates WHERE t_id = ?d', intval($site_layouts_id));
                            if ($site_layout) {
                                echo '<div>' . $site_layouts_id . ' - ' . $site_layout[0]['t_name'] . '</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new TBListRelatedSiteLayouts($_POST['path']);
            if (isset($_POST['page_urls']) && trim($_POST['page_urls']) != '') $li->layoutURL($_POST['page_urls']);
            else if (isset($_POST['page_url'])) $li->layoutURL($_POST['page_url'], true);
            $li->info();
        }
        if ($_GET['events'] == 'page_related_pages') {
            ?>
            <form method="POST">
                <input type="text" name="page_url" placeholder="URL страницы"><br>
                <textarea name="page_urls" placeholder="URLs страниц"></textarea><br>
                <label><input type="checkbox" name="path"
                              value="1" <?php echo (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : ''; ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class pageRelatedPages
            {


                /**
                 * @param array массив ID страниц
                 */
                private $page_ids;

                /**
                 * @param integer ID макета
                 */
                private $page_urls;

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function layoutURL($urls, $is_string = false)
                {
                    if ($is_string) $this->page_urls = array($urls);
                    else $this->page_urls = explode("\r\n", $urls);
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    foreach ($this->page_urls as $page_url) {
                        $page_ids = sql_assoc('SELECT e_tag, e_p_id FROM sb_elems WHERE e_ident LIKE "pl_pages_page" AND e_link LIKE "page" AND e_params LIKE "%' . $page_url . '%"');
                        if ($page_ids) {
                            foreach ($page_ids as $page_id) {
                                if (!array_key_exists($page_id['e_p_id'], $this->page_ids)) $this->page_ids[$page_id['e_p_id']] = $page_id['e_tag'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->page_ids) && count($this->page_ids) > 0) {
                        foreach ($this->page_ids as $id => $tag) {
                            if ($this->path) {
                                $query = 'SELECT l.link_cat_id FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id WHERE p_id = ?d';
                                $cat_ids = sql_assoc($query, intval($id));
                                $cats = array();
                                if ($cat_ids) foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                                $cats = sql_assoc('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_pages" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    echo '<div> Tag: ' . $tag . '</div>';
                                    echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $page = sql_assoc('SELECT p_name, p_filepath, p_filename FROM sb_pages WHERE p_id = ?d', intval($id));
                            if ($page) {
                                echo '<div>' . $id . ' - ' . $page[0]['p_name'] . ' (' . SB_DOMAIN . '/' . $page[0]['p_filepath'] . '/' . $page[0]['p_filename'] . ')</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new pageRelatedPages($_POST['path']);
            if (isset($_POST['page_urls']) && trim($_POST['page_urls']) != '') $li->layoutURL($_POST['page_urls']);
            else if (isset($_POST['page_url']) && trim($_POST['page_url']) != '') $li->layoutURL($_POST['page_url'], true);
            $li->info();
        }
        if ($_GET['events'] == 'text_block_related_site_layouts') {
            ?>
            <form method="POST">
                <input type="text" name="text_id" value="<?= (isset($_POST['text_id'])) ? $_POST['text_id'] : '' ?>"
                       placeholder="ID текстового блока"><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : '' ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class TBListRelatedSiteLayouts
            {


                /**
                 * @param array массив ID страниц
                 */
                private $site_layouts_ids;

                /**
                 * @param integer ID макета
                 */
                private $text_id;

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function layoutID($id)
                {
                    $this->text_id = $id;
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    $site_layouts_ids = sql_assoc('SELECT e_p_id FROM sb_elems WHERE e_ident LIKE "pl_texts_html" AND e_link LIKE "temp" AND e_el_id = ?d', intval($this->text_id));
                    // var_dump($m);
                    if ($site_layouts_ids) {
                        foreach ($site_layouts_ids as $site_layout) {
                            $this->site_layouts_ids[] = $site_layout['e_p_id'];
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->site_layouts_ids) && count($this->site_layouts_ids[0]) > 0) {
                        foreach ($this->site_layouts_ids as $site_layout_id) {
                            if ($this->path) {
                                $cat_ids = sql_assoc('SELECT l.link_cat_id FROM sb_templates t LEFT JOIN sb_catlinks l ON t.t_id = l.link_el_id WHERE t.t_id = ?d', intval($site_layout_id));
                                $cats = array();
                                if ($cat_ids) foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                                $cats = sql_assoc('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_templates" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $site_layout = sql_assoc('SELECT t_name FROM sb_templates WHERE t_id = ?d', intval($site_layout_id));
                            if ($site_layout) {
                                echo '<div>' . $site_layout_id . ' - ' . $site_layout[0]['t_name'] . '</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new TBListRelatedSiteLayouts($_POST['path']);
            if (isset($_POST['text_id'])) $li->layoutID($_POST['text_id']);
            $li->info();
        }
        if ($_GET['events'] == 'text_block_related_pages') {
            ?>
            <form method="POST">
                <input type="text" name="text_id" value="<?= (isset($_POST['text_id'])) ? $_POST['text_id'] : '' ?>"
                       placeholder="ID текстового блока"><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : ''; ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class TBListRelatedPages
            {


                /**
                 * @param array массив ID страниц
                 */
                private $page_ids;

                /**
                 * @param integer ID макета
                 */
                private $text_id;

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function layoutID($id)
                {
                    $this->text_id = $id;
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    $page_ids = sql_assoc('SELECT e_p_id FROM sb_elems WHERE e_ident LIKE "pl_texts_html" AND e_link LIKE "page" AND e_el_id = ?d', intval($this->text_id));
                    // var_dump($m);
                    if ($page_ids) {
                        foreach ($page_ids as $page) {
                            $this->page_ids[] = $page['e_p_id'];
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->page_ids) && count($this->page_ids) > 0) {
                        $domain = SB_DOMAIN;
                        foreach ($this->page_ids as $page_id) {
                            $cat_ids = sql_assoc('SELECT l.link_cat_id, l.link_src_cat_id, c.cat_id, c.cat_level, c.cat_closed
                                                        FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id 
                                                        LEFT JOIN sb_categs c ON c.cat_id = l.link_cat_id
                                                        WHERE p_id = ?d AND c.cat_ident LIKE "pl_pages"', intval($page_id));
                            $cats = $url_params = array();
                            if ($cat_ids) {
                                $url_params = array(
                                    'id' => $page_id,
                                    'ids' => $page_id,
                                    'cat_id' => $cat_ids[0]['cat_id'],
                                    'cat_level' => $cat_ids[0]['cat_level'],
                                    'cat_closed' => $cat_ids[0]['cat_closed'],
                                    'link_id' => $cat_ids[0]['link_cat_id'],
                                    'link_src_cat_id' => $cat_ids[0]['link_src_cat_id'],
                                );
                                foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                            }
                            if (count($cats) > 0) {
                                $cats = sql_assoc('SELECT c2.cat_title 
                                                    FROM sb_categs c1, sb_categs c2 
                                                    WHERE c1.cat_id IN (' . implode(',', $cats) . ')
                                                        AND c1.cat_ident LIKE "pl_pages" 
                                                        AND c1.cat_ident = c2.cat_ident 
                                                        AND c2.cat_left <= c1.cat_left 
                                                        AND c2.cat_right >= c1.cat_right 
                                                        ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) {
                                        if ($cat_name['cat_level'] == 1) {
                                            $domain = 'https://' . $cat_name['cat_title'];
                                        }
                                        $cat[] = $cat_name['cat_title'];
                                    }
                                    if ($this->path) echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $page = sql_assoc('SELECT p_name, p_filepath, p_filename FROM sb_pages WHERE p_id = ?d', intval($page_id));
                            if ($page) {
                                $url = '/cms/admin/modal_dialog.php?event=pl_pages_edit&real_event=pl_pages_init&id=' . $url_params['id'] . '&ids=' . $url_params['ids'] . '&cat_id=' . $url_params['cat_id'] . '&cat_level=' . $url_params['cat_level'] . '&cat_closed=' . $url_params['cat_closed'] . '&plugin_ident=pl_pages&link_id=' . $url_params['link_id'] . '&link_src_cat_id=' . $url_params['link_src_cat_id'];
                                echo '<div>' . $page_id . ' - ' . '<a href="javascript:void(0);" onclick="openPageInfo(\'' . $url . '\');">' . $page[0]['p_name'] . '</a> (<a href="' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '" target="_blank">' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '</a>)</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new TBListRelatedPages($_POST['path']);
            if (isset($_POST['text_id'])) $li->layoutID($_POST['text_id']);
            $li->info();
        }
        if ($_GET['events'] == 'form_related_pages') {
            ?>
            <form method="POST">
                <input type="text" name="layout_ids" placeholder="IDs макетов (через запятую)"
                       value="<?php echo isset($_POST['layout_ids']) ? $_POST['layout_ids'] : ''; ?>">
                <input type="text" name="modul_id" placeholder="ID модуля"
                       value="<?php echo isset($_POST['modul_id']) ? $_POST['modul_id'] : ''; ?>">
                <label><input type="checkbox" name="path"
                              value="1" <?php echo (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : ''; ?>>Выводить
                    путь</label>
                <input type="submit">
            </form>
            <?php

            class layoutInfo
            {


                /**
                 * @param array массив ID страниц
                 */
                private $page_ids;

                /**
                 * @param integer ID макета
                 */
                private $layout_ids;

                /**
                 * @param integer ID модуля
                 */
                private $modul_id = '%';

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function modulID($ids)
                {
                    $this->modul_id = intval($ids);
                }

                public function layoutIDs($ids)
                {
                    $this->layout_ids = explode(',', $ids);
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    foreach ($this->layout_ids as $layout_id) {
                        $page_ids = sql_assoc('SELECT e_p_id FROM sb_elems WHERE e_link LIKE "page" AND e_ident LIKE "pl_plugin_' . $this->modul_id . '_form" AND e_temp_id = ?d', intval($layout_id));
                        if ($page_ids) {
                            foreach ($page_ids as $page) {
                                $this->page_ids[] = $page['e_p_id'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->page_ids) && count($this->page_ids[0]) > 0) {
                        foreach ($this->page_ids as $page_id) {
                            if ($this->path) {
                                $cat_ids = sql_assoc('SELECT l.link_cat_id FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id WHERE p_id = ?d', intval($page_id));
                                $cats = array();
                                if ($cat_ids) foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                                $cats = sql_assoc('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_pages" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $page = sql_assoc('SELECT p_name, p_filepath, p_filename FROM sb_pages WHERE p_id = ?d', intval($page_id));
                            if ($page) {
                                echo '<div>' . $page_id . ' - ' . $page[0]['p_name'] . ' (' . SB_DOMAIN . '/' . $page[0]['p_filepath'] . '/' . $page[0]['p_filename'] . ')</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new layoutInfo($_POST['path']);
            if (isset($_POST['modul_id'])) $li->modulID($_POST['modul_id']);
            if (isset($_POST['layout_ids'])) $li->layoutIDs($_POST['layout_ids']);
            $li->info();
        }
        if ($_GET['events'] == 'related_pages') {
            ?>
            <form method="POST">
                <input type="text" name="layout_ids"
                       value="<?= (isset($_POST['layout_ids'])) ? $_POST['layout_ids'] : '' ?>"
                       placeholder="IDs макетов (через запятую)"><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : ''; ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class layoutInfo
            {


                /**
                 * @param array массив ID страниц
                 */
                private $page_ids;

                /**
                 * @param integer ID макета
                 */
                private $layout_ids;

                /**
                 * @param boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path)
                {
                    $this->path = $path;
                }

                public function layoutIDs($ids)
                {
                    $this->layout_ids = explode(',', $ids);
                    $this->getPageIds();
                }

                private function getPageIds()
                {
                    foreach ($this->layout_ids as $layout_id) {
                        $page_ids = sql_assoc('SELECT p_id FROM sb_pages WHERE p_temp_id = ?d', intval($layout_id));
                        if ($page_ids) {
                            foreach ($page_ids as $page) {
                                $this->page_ids[] = $page['p_id'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->page_ids) && count($this->page_ids[0]) > 0) {
                        $domain = SB_DOMAIN;
                        foreach ($this->page_ids as $page_id) {
                            $cat_ids = sql_assoc('SELECT l.link_cat_id, l.link_src_cat_id, c.cat_id, c.cat_level, c.cat_closed
                                                        FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id 
                                                        LEFT JOIN sb_categs c ON c.cat_id = l.link_cat_id
                                                        WHERE p_id = ?d AND c.cat_ident LIKE "pl_pages"', intval($page_id));
                            $cats = $url_params = array();
                            if ($cat_ids) {
                                $url_params = array(
                                    'id' => $page_id,
                                    'ids' => $page_id,
                                    'cat_id' => $cat_ids[0]['cat_id'],
                                    'cat_level' => $cat_ids[0]['cat_level'],
                                    'cat_closed' => $cat_ids[0]['cat_closed'],
                                    'link_id' => $cat_ids[0]['link_cat_id'],
                                    'link_src_cat_id' => $cat_ids[0]['link_src_cat_id'],
                                );
                                foreach ($cat_ids as $cat) $cats[] = $cat['link_cat_id'];
                            }
                            if (count($cats) > 0) {
                                $cats = sql_assoc('SELECT c2.cat_title, c2.cat_level FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_pages" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                //var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) {
                                        if ($cat_name['cat_level'] == 1) {
                                            $domain = 'https://' . $cat_name['cat_title'];
                                        }
                                        $cat[] = $cat_name['cat_title'];
                                    }
                                    if ($this->path) echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $page = sql_assoc('SELECT p_name, p_filepath, p_filename FROM sb_pages WHERE p_id = ?d', intval($page_id));
                            if ($page) {
                                $url = '/cms/admin/modal_dialog.php?event=pl_pages_edit&real_event=pl_pages_init&id=' . $url_params['id'] . '&ids=' . $url_params['ids'] . '&cat_id=' . $url_params['cat_id'] . '&cat_level=' . $url_params['cat_level'] . '&cat_closed=' . $url_params['cat_closed'] . '&plugin_ident=pl_pages&link_id=' . $url_params['link_id'] . '&link_src_cat_id=' . $url_params['link_src_cat_id'];
                                echo '<div>' . $page_id . ' - ' . '<a href="javascript:void(0);" onclick="openPageInfo(\'' . $url . '\');">' . $page[0]['p_name'] . '</a> (<a href="' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '" target="_blank">' . $domain . (trim($page[0]['p_filepath']) != '' ? '/' . $page[0]['p_filepath'] : '') . '/' . $page[0]['p_filename'] . '</a>)</div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Не указан ID страницы';
                }
            }

            $li = new layoutInfo(isset($_POST['path']) && $_POST['path']);
            if (isset($_POST['layout_ids'])) $li->layoutIDs($_POST['layout_ids']);
            $li->info();
        }
        if ($_GET['events'] == 'site_layouts') {
            ?>
            <form method="POST">
                <input type="text" name="layout_name"
                       value="<?= (isset($_POST['layout_name'])) ? $_POST['layout_name'] : '' ?>"
                       placeholder="Название шаблона"><br>
                <input type="text" name="layout_id" value="<?= (isset($_POST['layout_id'])) ? $_POST['layout_id'] : '' ?>"
                       placeholder="ID шаблона"><br>
                <textarea name="text"
                          placeholder="Текст шаблона"><?= (isset($_POST['text'])) ? $_POST['text'] : ''; ?></textarea><br>
                <textarea name="layout_component"
                          placeholder="Текст компонента шаблона"><?= (isset($_POST['layout_component'])) ? $_POST['layout_component'] : ''; ?></textarea><br>
                <label><input type="checkbox" name="path"
                              value="1" <?= (isset($_POST['path']) && $_POST['path'] == 1) ? ' checked' : '' ?>>Выводить
                    путь</label><br>
                <input type="submit">
            </form>
            <?php

            class Templates
            {

                /**
                 * @var array массив ID страниц
                 */
                private $templates_ids;

                /**
                 * @var boolen флаг вывода пути разделов к странице
                 */
                private $path;

                public function __construct($path = false)
                {
                    $this->path = $path;
                }

                public function templatesID($id)
                {
                    $id = trim($id);
                    if ($id == '') return;
                    $this->templates_ids = explode(',', $id);
                }

                public function templatesName($name)
                {
                    $name = trim($name);
                    if ($name == '') return;
                    $templates = sql_assoc('SELECT t_id FROM sb_templates WHERE t_name LIKE "%' . $name . '%"');
                    if ($templates) {
                        foreach ($templates as $template) {
                            $this->templates_ids[] = $template['t_id'];
                        }
                    }
                }

                public function templates_text($text)
                {
                    if (trim($text) != '' && strlen(trim($text)) > 3) {
                        $res = sql_assoc('SELECT t.t_id FROM sb_catlinks l LEFT JOIN sb_categs c ON l.link_cat_id = c.cat_id LEFT JOIN sb_templates t ON l.link_el_id = t.t_id WHERE c.cat_ident LIKE "pl_templates" AND t.t_html LIKE "%' . $text . '%" GROUP BY t.t_id');

                        if ($res)
                            foreach ($res as $value) {
                                $this->templates_ids[] = $value['t_id'];
                            }
                    }
                }

                public function templatesComponents($str)
                {
                    if (trim($str) != '') {
                        $templates = sql_assoc('SELECT t.t_id FROM sb_templates t INNER JOIN sb_elems e ON e.e_p_id = t.t_id WHERE e.e_link LIKE "temp" AND e.e_params LIKE "%' . $str . '%"');
                        if ($templates) {
                            foreach ($templates as $template) {
                                $this->templates_ids[] = $template['t_id'];
                            }
                        }
                    }
                }

                public function info()
                {
                    if (is_array($this->templates_ids) && intval($this->templates_ids[0]) > 0) {
                        foreach ($this->templates_ids as $templates_id) {
                            if ($this->path) {
                                $cat_ids = sql_assoc('SELECT l.link_cat_id, l.link_src_cat_id, c.cat_id, c.cat_level, c.cat_closed
                                                        FROM sb_templates t LEFT JOIN sb_catlinks l ON t.t_id = l.link_el_id 
                                                        LEFT JOIN sb_categs c ON c.cat_id = l.link_cat_id
                                                        WHERE t.t_id = ?d AND c.cat_ident LIKE "pl_templates"', intval($templates_id));
                                // var_dump($cat_ids);
                                $cats = $url_params = array();
                                if ($cat_ids) {
                                    $url_params = array(
                                        'id' => $templates_id,
                                        'ids' => $templates_id,
                                        'cat_id' => $cat_ids[0]['cat_id'],
                                        'cat_level' => $cat_ids[0]['cat_level'],
                                        'cat_closed' => $cat_ids[0]['cat_closed'],
                                        'link_id' => $cat_ids[0]['link_cat_id'],
                                        'link_src_cat_id' => $cat_ids[0]['link_src_cat_id'],
                                    );
                                    foreach ($cat_ids as $cat) $cats[] = $cat['cat_id'];
                                }
                                $cats = sql_assoc('SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id IN (' . implode(',', $cats) . ') AND c1.cat_ident LIKE "pl_templates" AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC');
                                // var_dump($cats);
                                if ($cats) {
                                    $cat = array();
                                    foreach ($cats as $cat_name) $cat[] = $cat_name['cat_title'];
                                    echo '<div>' . implode(' -> ', $cat) . '</div>';
                                }
                            }
                            $templates = sql_assoc('SELECT t_name FROM sb_templates WHERE t_id = ?d', intval($templates_id));
                            if ($templates) {
                                $url = '/cms/admin/modal_dialog.php?event=pl_templates_edit&id=' . $url_params['id'] . '&ids=' . $url_params['ids'] . '&cat_id=' . $url_params['cat_id'] . '&cat_level=' . $url_params['cat_level'] . '&cat_closed=' . $url_params['cat_closed'] . '&plugin_ident=pl_templates&link_id=' . $url_params['link_id'] . '&link_src_cat_id=' . $url_params['link_src_cat_id'];
                                echo '<div>' . $templates_id . ' - <a href="javascript:void(0);" onclick="openPageInfo(\'' . $url . '\');">' . $templates[0]['t_name'] . '</a></div>';
                            }
                            if ($this->path) echo '<br>';
                        }
                    } else echo 'Макеты на найдены';
                }
            }

            $t = new Templates(isset($_POST['path'])&&$_POST['path']==1);
            if (isset($_POST['layout_name'])) $t->templatesName($_POST['layout_name']);
            if (isset($_POST['layout_id'])) $t->templatesID($_POST['layout_id']);
            if (isset($_POST['text'])) $t->templates_text($_POST['text']);
            if (isset($_POST['layout_component'])) $t->templatesComponents($_POST['layout_component']);
            $t->info();
        }
        if ($_GET['events'] == 'mail') {

            $subject = 'Тест отправки писем 1';

            $message_text = 'Тест отправки писем с сайта 1';

            $emailFrom = 'rosbank.ru <info@rosbank.ru>';
            $emailTo = array('ab@binn.ru');
            $mail = new sbMail;

            $mail->setHeadCharset('windows-1251');
            $mail->setHtmlCharset('windows-1251');
            $mail->setFrom($emailFrom);
            $mail->setSubject($subject);
            $mail->setHtml($message_text);

            // Создание ZIP-архива
            $zip = new ZipArchive;
            $filename = "test112.zip";
            if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                exit("Невозможно открыть <$filename>\n");
            }
            $zip->addFromString("testfilephp.txt", "#1 Это тестовая строка, добавленная как testfilephp.txt.\n");
            $zip->close();

            // Открываем файл для чтения в бинарном формате
            $file = fopen($filename, "rb");
            // Считываем его в строку $str_file
            $str_file = fread($file, filesize($filename));
            // Преобразуем эту строку в base64-формат
            // $str_file=base64_encode($str_file);

            $mail->addAttachment($str_file, 'test112' . time() . '.zip.xml');
            if (!$mail->send($emailTo)) echo 'Mail not send';
        }
        if ($_GET['events'] == 'system_log') {
            ?>
            <form method="POST">
                <input type="text" name="text" placeholder="Искомый текст"
                       value="<?php if (isset($_POST['text'])) echo $_POST['text']; ?>">
                <input type="submit">
            </form>
            <?php

            class textInfo
            {

                /**
                 * @var $text Искомый текст
                 */
                private $text;

                public function text($text)
                {
                    $this->text = $text;
                }

                public function info()
                {
                    if (!trim($this->text))
                        $text = sql_assoc('SELECT sl_date, sl_message FROM sb_system_log WHERE sl_type = 2 ORDER BY sl_date DESC LIMIT 10');
                    else
                        $text = sql_assoc('SELECT sl_date, sl_message FROM sb_system_log WHERE sl_message LIKE "%' . $this->text . '%" ORDER BY sl_date DESC LIMIT 10');
                    if ($text)
                        foreach ($text as $row) {
                            echo date('Y-m-d H:i:s', $row['sl_date']) . ' ' . $row['sl_message'] . '<br>';
                        }
                }
            }

            $ts = new textInfo();
            if (isset($_POST['text'])) $ts->text($_POST['text']);
            $ts->info();
        }
        if ($_GET['events'] == 'news') { // новости?>
            <?php
            $query = 'SELECT n_id, n_title, n_short_foto FROM sb_news WHERE n_short_foto LIKE "%http://www.rosbank.ru%" OR n_full_foto LIKE "%http://www.rosbank.ru%" LIMIT 10';
            $res = sql_assoc($query);
            //$res = sql_query($query);
            if ($res) {
                //var_dump($res);
                echo '<table>';
                foreach ($res as $v) {
                    echo '<tr>';
                    foreach ($v as $n => $f) echo '<td>' . $n . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    foreach ($v as $n => $f) {
                        echo '<td>' . $f . '</td>';
                        $v['n_short_foto'] = str_replace('http://www.rosbank.ru', '' . SB_DOMAIN . '', $v['n_short_foto']);
                        $v['n_full_foto'] = str_replace('http://www.rosbank.ru', '' . SB_DOMAIN . '', $v['n_full_foto']);
                        sql_query('UPDATE sb_news SET n_short_foto = ?, n_full_foto = ? WHERE n_id = ?d', $v['n_short_foto'], $v['n_full_foto'], $v['n_id']);
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '<style>';
                echo 'table td { border: 1px solid}';
                echo '</style>';
            }
        }
        if ($_GET['events'] == 'copy_file') {
            /*require_once $_SERVER['DOCUMENT_ROOT'].'/cms/kernel/prog/header.inc.php';
            require_once(SB_BASEDIR.'/cms/plugins/own/pl_migration_import/pl_migration_import.php');
            //$result = fImportMake();
            $name = 'sbServicesRutube.inc.php';
            $path = '/cms/lib/prog/';
            $file = SB_BASEDIR.$path.$name;
            $newfile = SB_BASEDIR.$path.'NEW'.$name;*/

            /*if (!copy($file, $newfile)) {
            echo "не удалось скопировать $file...\n";
            } else echo "$file скопирован \n";*/
            $start = mktime();
            $filename = SB_BASEDIR . '/system/test.csv';
            //unlink($filename);
            $file = fopen($filename, 'w');
            $curl = curl_init();

            //$filename = SB_BASEDIR.'/upload/import/STW_Fast.csv';


            unlink($filename);
            $file = fopen($filename, 'w');
            var_dump($file);
            $host = $GLOBALS['sb_ftp_host'];
            $host = '10.49.12.98';
            $port = $GLOBALS['sb_ftp_port'];
            $port = '990';
            $login = $GLOBALS['sb_ftp_login'];
            $login = 'RBLotus';
            $pass = $GLOBALS['sb_ftp_password'];
            $pass = 'Jn5*ff3K';
            //echo $pass.'<br>';
            $url = 'ftps://' . $host . ':' . $port . '/RBLotus/In/branches_report.csv';
            $url = 'ftps://' . $host . ':' . $port . '/RBLotus/branches_report.csv';
            $url = 'ftps://' . $host . ':' . $port . '/In/branches_report.csv';
            echo $url . '<br>';
            //$url = 'ftps://'.$GLOBALS['sb_ftp_host'].':'.$GLOBALS['sb_ftp_port'].'/In/STH250716_1540.csv';
            //$url = 'ftps://'.$GLOBALS['sb_ftp_host'].':'.$GLOBALS['sb_ftp_port'].'/In/STW160617_0957.csv';
            //$url = 'http://www.rosbank.ru/upload/import/STW.CSV';
            //CHANGES

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERPWD, $login . ':' . $pass);
            curl_setopt($curl, CURLOPT_FILE, $file);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, '600');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_FAILONERROR, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);

            $result = curl_exec($curl);
            curl_close($curl);
            //fclose($file);

            if ((!$result)) {
                var_dump(array(
                    'errors' => array('Не удалось установить соединение с FTP сервером ' . $host . '. Отсутствует файл ' . $url),
                    'time' => mktime() - $start
                ));
            } else var_dump($result);


            if (!is_file($filename)) {
                echo('Ошибка! Не удалось копирование файла.');
            }

            $homepage = file_get_contents($filename);
            echo $homepage;
        }
        if ($_GET['events'] == 'sql-query') {
            /*$query = 'SELECT s.p_id, s.user_f_23, s.user_f_24, s.user_f_25, s.user_f_27, s.user_f_48, s.user_f_4, s.user_f_21, s.user_f_1, s.user_f_26, s.user_f_5, s.p_title, c.cat_id
            FROM sb_plugins_120 s
            JOIN sb_catlinks l ON l.link_el_id = s.p_id AND l.link_cat_id IN (5729,5730,5748)
            JOIN sb_categs c ON c.cat_id = l.link_cat_id AND c.cat_ident = "pl_plugin_120"
            WHERE s.user_f_42 = 0 ORDER BY s.p_id DESC LIMIT 25';
            $res = sql_assoc($query);*/

            $field = 'user_f_109';

            //$query = 'UPDATE sb_plugins_2 SET '.$field.' = "1850" WHERE '.$field.' = "3637"';

            //$query = 'SELECT '.$field.' FROM sb_plugins_2 WHERE p_id = "3422"';

            //$query = 'SELECT l.link_cat_id FROM sb_catlinks l LEFT JOIN sb_categs c ON l.link_cat_id = c.cat_id WHERE c.cat_ident LIKE "pl_sprav" AND l.link_el_id IN (3634,3635,3637)';

            // ==========================
            // Поиск по сайту
            // ==========================

            // Проверяю типы индексации
            //$query = 'SELECT e_search FROM sb_elems GROUP BY e_search';

            // Вывод родительских разделов
            //$query = 'SELECT count(c2.cat_id) FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 2022 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left ASC';

            // нахожу список страниц выбранных разделов
            //$query = 'SELECT link_el_id FROM sb_catlinks WHERE link_cat_id IN (SELECT c2.cat_id FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 3255 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left ASC)';

            // нахожу страницы для в таблице типов индексации
            //$query = 'SELECT * FROM sb_elems WHERE e_tag LIKE "{AUTOTITLE}" AND e_p_id IN (SELECT link_el_id FROM sb_catlinks WHERE link_cat_id IN (SELECT c2.cat_id FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 2022 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left ASC))';
            //$query = 'SELECT * FROM sb_elems WHERE e_search = "none"';

            // устанавливаю тип индексации Текст и ссылки для всех копонентов найденых страниц
            //$query = 'UPDATE sb_elems SET e_search = "none" WHERE e_tag LIKE "{AUTOTITLE}" AND e_p_id IN (SELECT link_el_id FROM sb_catlinks WHERE link_cat_id IN (SELECT c2.cat_id FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 2022 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left ASC))';

            // устанавливаю тип индексации Текст и ссылки для всех копонентов найденых страниц
            //$query = 'UPDATE sb_elems SET e_search = "none" WHERE e_tag LIKE "{КАСТОМНЫЙ_КЛАСС}" AND e_p_id IN (SELECT link_el_id FROM sb_catlinks WHERE link_cat_id IN (SELECT c2.cat_id FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 2022 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left ASC))';

            // вывод курсов валют
            //$query = 'SELECT * FROM sb_plugins_13 ORDER BY p_id DESC LIMIT 1';

            // вывод полей Банкоматов
            //$query = 'SELECT * FROM sb_plugins_2 WHERE user_f_94 = 53930';

            // KLADR
            /*$query = 'SELECT
            b1.id, b1.prefix, b1.name,
            b2.prefix, b2.name,
            b3.prefix, b3.name,
            b4.prefix, b4.name,
            b5.prefix, b5.name,
            b6.prefix, b6.name
            FROM kladr_base b1
            LEFT JOIN kladr_base b2 ON b2.id = b1.pid
            LEFT JOIN kladr_base b3 ON b3.id = b2.pid
            LEFT JOIN kladr_base b4 ON b4.id = b3.pid
            LEFT JOIN kladr_base b5 ON b5.id = b4.pid
            LEFT JOIN kladr_base b6 ON b6.id = b5.pid
            WHERE b1.level >= 1';*/

            // вывод страницы Мерседес
            //$query = 'SELECT t_id, t_name FROM sb_templates WHERE t_html LIKE "%рседес%"';
            //$query = 'SELECT p_id, p_name, p_state FROM sb_pages WHERE p_temp_id IN (292,244,246,263,264,267,290,294)';


            /*$query = 'SELECT p.p_id, p.p_title
            FROM sb_plugins_126 p, sb_catlinks l
            WHERE l.link_el_id = p.p_id AND
            l.link_cat_id = 6028';*/
            //$query = 'SELECT p.p_id, p.p_title FROM sb_plugins_126 p LIMIT 0, 10';
            //$query = 'SELECT e_params FROM sb_elems';
            //$res = sql_assoc($query);
            //$res = sql_query('SELECT cat_left, cat_right, cat_ident, cat_title FROM sb_categs WHERE cat_id=66');
            //$query = 'SELECT * FROM sb_plugins_113 WHERE p_id = 209712';

            // ==========================
            // Информационные ссылки
            // ==========================

            // Нахожу ссылку по ID
            //$query = 'SELECT * FROM sb_plugins_21 WHERE p_id = 1275';

            // Устанавливаю название для ссылки
            //$query = 'UPDATE sb_plugins_21 SET p_title = "Общие условия договора потребительского кредита с лимитом кредитования (Кредитная карта)(версия - 0006р)  (с 04.07.17) Для договоров, заключенных после 09.12.2015" WHERE p_id = 1275';
            //$query = 'SELECT * FROM sb_plugins_113 WHERE p_id = 209712';

            // ==========================
            // Поиск разделов
            // ==========================

            // Нахожу дерево родительских разделов
            //$query = 'SELECT c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 5299 AND c1.cat_ident = c2.cat_ident AND c2.cat_left <= c1.cat_left AND c2.cat_right >= c1.cat_right ORDER BY c2.cat_left ASC';

            // ==========================
            // Проверка полей таблицы sb_users
            // ==========================

            // Нахожу
            //$query = 'SELECT * FROM sb_users LIMIT 0,10';

            // ==========================
            // Проверка полей таблицы promocodes
            // ==========================

            // Нахожу
            //$query = 'SELECT code FROM promocodes ORDER BY code DESC LIMIT 1';

            // ==========================
            // Поиск отделения
            // ==========================

            // Нахожу отделение
            //$query = 'SELECT * FROM sb_plugins_1 WHERE p_title LIKE "%Арбеково%"';

            // ==========================
            // Поиск банкоматов
            // ==========================

            // Нахожу банкомат
            //$query = 'SELECT p_id,  FROM sb_plugins_2 WHERE p_id = 45414 AND (user_f_127 LIKE "%3634%" OR user_f_127 LIKE "%3635%" OR user_f_127 LIKE "%3637%")';

            // ==========================
            // Заявка на ПРОМОКОД
            // ==========================

            // Копирую содержимое поля Метка со старого поля
            //$query = 'UPDATE sb_plugins_124 SET user_f_28 = user_f_27 WHERE user_f_27 <> ""';

            // ==========================
            // Заявка на ОБЗВОН
            // ==========================

            // Копирую содержимое поля Метка со старого поля
            //$query = 'UPDATE sb_plugins_113 SET user_f_50 = user_f_49 WHERE user_f_49 <> ""';

            // Добавляю поле в модуль Заявка на обзвон
            //$query = 'ALTER TABLE sb_plugins_113 ADD user_f_49 VARCHAR(225) AFTER user_f_50';

            // Нахожу элементы
            //$query = 'SELECT * FROM sb_plugins_113 WHERE user_f_3 LIKE "9834216423"';

            // Нахожу раздел элемента
            //$query = 'SELECT c.cat_id FROM sb_categs c LEFT JOIN sb_catlinks l ON c.cat_id=l.link_cat_id WHERE l.link_el_id = 393158 AND c.cat_ident LIKE "pl_plugin_113"';
            //$query = 'SELECT c2.* FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 66 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left  ASC';

            // Получаю список разделов
            //$query = 'SELECT c2.* FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 66 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left  ASC';

            // Получаю список разделов
            //$query = 'SELECT c2.* FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = 66 AND c1.cat_ident = c2.cat_ident AND c2.cat_left >= c1.cat_left AND c2.cat_right <= c1.cat_right ORDER BY c2.cat_left  ASC';

            // Получаю поля модуля "Потребительские кредиты"
            // $query = 'SELECT pd_fields FROM sb_plugins_data WHERE pd_plugin_ident LIKE "pl_plugin_53"';
            // $res = sql_query($query);

            // Удаляю таблицу sb_plugins_data_Copy
            // $query = 'DROP TABLE sb_plugins_data_Copy';
            // $res = sql_query($query);

            // Восстнанавливаю значение поля из восстновленной таблицы
            // $query = 'UPDATE sb_plugins_data SET pd_fields = (SELECT pd_fields FROM sb_plugins_data_Copy WHERE pd_plugin_ident LIKE "pl_plugin_53") WHERE pd_plugin_ident LIKE "pl_plugin_53"';
            // $res = sql_query($query);

            // $query = 'UPDATE sb_plugins_data SET pd_fields=? WHERE pd_plugin_ident LIKE "pl_plugin_53"';
            // $res = sql_param_query($query,$update);

            // $query = 'SELECT * FROM sb_plugins_53';
            // $res = sql_assoc($query);

            if ($res) {
                //$tmp = unserialize($data);
                //var_dump($res);
                //foreach($res as $val) echo $val['t_id'].',';
                echo '<table>';
                foreach ($res as $v) {
                    echo '<tr>';
                    foreach ($v as $n => $f) echo '<td>' . $n . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    foreach ($v as $n => $f) echo '<td>' . $f . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<style>';
                echo 'table td { border: 1px solid}';
                echo '</style>';
            }
            /*$time = '12:00';
            $h1 = date('H');
            list($h, $m) = explode(':', $time);
            if($h > $h1){
            $datetime = date( "d.m.Y H:i:s", mktime($h, '00', '00', date('m'), date('d'), date('Y')) );
            }else{
                $datetime =  date( "d.m.Y H:i:s", mktime($h, '00', '00', date('m'), date('d')+1, date('Y')) );
            }
                echo $datetime."<br>";*/
            /*user_f_107    case/first/Currency
            user_f_108    case/second/Currency
            user_f_109    case/third/Currency
            user_f_110    case/fourth/Currency

            $currency = array(
            '1848' => 'RUR', '3634' => 'RUR',
            '1849' => 'USD', '3635' => 'USD',
            '1850' => 'EUR', '3637' => 'EUR'
            );*/
        }
        if ($_GET['events'] == 'pages_tree') {

            $filename = SB_BASEDIR . '/system/folder_structure.csv';
            $xml_file = fopen($filename, 'w');
            $level = array();
            $i_p = $i_c = 0;

            // Нахожу раздел элемента
            $query = 'SELECT c2.cat_id, c2.cat_level, c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = ?d AND c1.cat_ident = c2.cat_ident AND c1.cat_left <= c2.cat_left AND c1.cat_right >= c2.cat_right ORDER by c2.cat_left';

            $res = sql_assoc($query, 2006);
            if ($res) {
                foreach ($res as $v) {
                    $level[$v['cat_level']] = strip_tags($v['cat_title']);
                    $cat_path = array();
                    foreach ($level as $k => $val) {
                        if ($k > $v['cat_level']) break;
                        $cat_path[] = $val;
                    }
                    $i_c++;
                    echo $cat = 'categ ' . $v['cat_id'] . ' ' . implode(' -> ', $cat_path) . "\r\n";
                    echo '<br>';
                    fwrite($xml_file, $cat);
                    $query = 'SELECT p.p_id, p.p_name, p.p_filepath, p.p_filename FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id WHERE l.link_cat_id = ?d';
                    $pages = sql_assoc($query, $v['cat_id']);
                    if ($pages) {
                        foreach ($pages as $p) {
                            $url = '' . SB_DOMAIN . '';
                            if (trim($p['p_filepath']) != '') $url .= '/' . $p['p_filepath'];
                            if (trim($p['p_filename']) != '') $url .= '/' . $p['p_filename'];
                            $i_p++;
                            $page = "\t" . 'page  ' . $p['p_id'] . ' "' . strip_tags($p['p_name']) . '" (' . $url . ")\r\n";
                            echo $page . '<br>';
                            fwrite($xml_file, $page);
                        }
                    }
                }
                fclose($xml_file);
            }
        }
        if ($_GET['events'] == 'missing_pages') {

            $base_cat_id = 2006;
            //$base_cat_id = 2064;
            //$base_cat_id = 2272;
            $filename = SB_BASEDIR . '/system/missing_pages.csv';
            $xml_file = fopen($filename, 'w');
            $level = array();
            $i_p = $i_c = 0;

            // Нахожу раздел элемента
            $query = 'SELECT c2.cat_id, c2.cat_level, c2.cat_title FROM sb_categs c1, sb_categs c2 WHERE c1.cat_id = ?d AND c1.cat_ident = c2.cat_ident AND c1.cat_left <= c2.cat_left AND c1.cat_right >= c2.cat_right ORDER by c2.cat_left';

            $res = sql_assoc($query, $base_cat_id);
            if ($res) {
                foreach ($res as $v) {
                    $level[$v['cat_level']] = strip_tags($v['cat_title']);
                    $cat_path = array();
                    foreach ($level as $k => $val) {
                        if ($k > $v['cat_level']) break;
                        $cat_path[] = $val;
                    }
                    $i_c++;
                    $cat = implode(' -> ', $cat_path);
                    //fwrite($xml_file, $cat);
                    $query = 'SELECT p.p_id, p.p_name, p.p_filepath, p.p_filename, p.p_state  FROM sb_pages p LEFT JOIN sb_catlinks l ON p.p_id = l.link_el_id WHERE l.link_cat_id = ?d';
                    $pages = sql_assoc($query, $v['cat_id']);
                    if ($pages) {
                        foreach ($pages as $p) {
                            $url = '' . SB_DOMAIN . '';
                            if (trim($p['p_filepath']) != '') $url .= '/' . $p['p_filepath'];
                            if (trim($p['p_filename']) != '') $url .= '/' . $p['p_filename'];
                            //$header = get_headers($url);
                            //if (strpos($header[0],'404')) {
                            if ($p['p_state'] != 1) {
                                $i_p++;
                                $page = $p['p_id'] . ' "' . strip_tags($p['p_name']) . '" (' . $url . ", " . $cat . ")\r\n";
                                echo $page . '<br>';
                                fwrite($xml_file, $page);
                            }
                        }
                    }
                }
                fclose($xml_file);
            }
        }
        if ($_GET['events'] == 'moduls_page') {

            $filename = SB_BASEDIR . '/system/module_pages.csv';
            $xml_file = fopen($filename, 'w');


            $m = array(
                'pl_plugin_16' => 'Feedback',
                'pl_plugin_126' => 'MIGRATION (страница для менеджеров)',
                'pl_plugin_55' => 'Автокредиты',
                'pl_plugin_49' => 'Акции и облигации',
                'pl_plugin_27' => 'Анкета для маркетинга',
                'pl_plugin_100' => 'Анкета по обслуживанию клиентов',
                'pl_plugin_87' => 'Анкета соискателя',
                'pl_plugin_56' => 'Банковские карты',
                'pl_plugin_82' => 'Банковские карты ПРО',
                'pl_plugin_2' => 'Банкоматы',
                'pl_plugin_17' => 'Банкоматы банков-партнёров',
                'pl_imagelib' => 'Библиотека изображений',
                'pl_plugin_14' => 'Вакансии',
                'pl_plugin_81' => 'Видеоролики',
                'pl_plugin_109' => 'Витрина имущества',
                'pl_plugin_58' => 'Витрина продуктов',
                'pl_faq' => 'Вопрос-Ответ',
                'pl_plugin_118' => 'Всплывающие тексты',
                'pl_plugin_52' => 'Депозитные продукты',
                'pl_plugin_76' => 'Депозиты ПРО',
                'pl_plugin_50' => 'Дивиденды',
                'pl_plugin_97' => 'Доступные операции',
                'pl_plugin_94' => 'Единая заявка на розничный кредит',
                'pl_plugin_89' => 'Единая заявка по продуктам МСБ',
                'pl_plugin_69' => 'Заявка "Стать Партнером Росбанка"',
                'pl_plugin_112' => 'Заявка - витрина имущества',
                'pl_plugin_103' => 'Заявка - зарплатный проект',
                'pl_plugin_39' => 'Заявка МСБ на консультацию специалиста Банка',
                'pl_plugin_116' => 'Заявка на MGM',
                'pl_plugin_105' => 'Заявка на звонок для физических лиц',
                'pl_plugin_25' => 'Заявка на ипотеку',
                'pl_plugin_51' => 'Заявка на карту "Мой стиль" и "ОтЛичный стиль"',
                'pl_plugin_123' => 'Заявка на копии документов',
                'pl_plugin_113' => 'Заявка на обзвон',
                'pl_plugin_93' => 'Заявка на получение ПТС',
                'pl_plugin_124' => 'Заявка на промокод',
                'pl_plugin_95' => 'Заявки на карты',
                'pl_plugin_20' => 'Заявки на сейфовую ячейку',
                'pl_plugin_5' => 'Иерархические тексты',
                'pl_plugin_21' => 'Информационные ссылки',
                'pl_plugin_64' => 'Ипотека',
                'pl_plugin_117' => 'Ипотека новая',
                'pl_plugin_46' => 'Ипотечные кредиты',
                'pl_plugin_40' => 'Ипотечный калькулятор',
                'pl_plugin_62' => 'История бренда',
                'pl_plugin_61' => 'Источник для рекламных кампаний',
                'pl_plugin_38' => 'Калькулятор Автостатус',
                'pl_plugin_125' => 'Калькулятор Рефинансирования',
                'pl_plugin_34' => 'Калькулятор для малого бизнеса',
                'pl_plugin_119' => 'Компании группы Societe Generale',
                'pl_plugin_88' => 'Кредиты ПРО',
                'pl_plugin_13' => 'Курсы валют',
                'pl_maillist' => 'Листы рассылки',
                'pl_plugin_122' => 'Магазины ОКЕЙ',
                'pl_plugin_92' => 'Места реализации скидок',
                'pl_plugin_18' => 'Местоположение',
                'pl_plugin_35' => 'Монеты из драгоценных металлов',
                'pl_menu' => 'Навигация по сайту',
                'pl_plugin_106' => 'Написать руководителю',
                'pl_news' => 'Новостная лента',
                'pl_plugin_7' => 'Обратная связь: ДБО - ИБ',
                'pl_plugin_121' => 'Обратная связь: ДБО - ИКБ',
                'pl_plugin_8' => 'Обратная связь: ДБО - МКБ',
                'pl_plugin_6' => 'Обратная связь: ДБО - ЮЛ',
                'pl_plugin_41' => 'Обратная связь: Депозитарий',
                'pl_plugin_12' => 'Обратная связь: Ипотека',
                'pl_plugin_11' => 'Обратная связь: Общий',
                'pl_plugin_24' => 'Обратная связь: Ошибка',
                'pl_plugin_120' => 'Обратная связь: Поделиться впечатлениями',
                'pl_plugin_65' => 'Обратная связь: конкурс по ипотеке',
                'pl_plugin_98' => 'Обратная связь: направить предложение "Что можно о',
                'pl_polls' => 'Опросы',
                'pl_plugin_1' => 'Отделения',
                'pl_plugin_57' => 'Пакеты банковских услуг',
                'pl_plugin_66' => 'Партнёры дисконтной программы',
                'pl_plugin_59' => 'Подписка на пресс-релизы',
                'pl_plugin_28' => 'Получатели платежей',
                'pl_site_users' => 'Пользователи сайта',
                'pl_users' => 'Пользователи системы',
                'pl_plugin_53' => 'Потребительские кредиты',
                'pl_plugin_115' => 'Программа лояльности',
                'pl_plugin_78' => 'Продуктовая корзина МСБ',
                'pl_plugin_111' => 'Промо-страницы',
                'pl_plugin_72' => 'Результаты опросов',
                'pl_plugin_79' => 'Резюме',
                'pl_banners' => 'Рекламные кампании',
                'pl_plugin_48' => 'Сообщения',
                'pl_plugin_102' => 'Список результатов опросов ЦУК',
                'pl_plugin_67' => 'Ссылки для социальных сетей',
                'pl_plugin_4' => 'Тарифы',
                'pl_plugin_45' => 'Тарифы - Финансовые институты',
                'pl_plugin_43' => 'Тарифы МСБ',
                'pl_plugin_31' => 'Тарифы ФЛ: Общебанковские (3, 4)',
                'pl_plugin_32' => 'Тарифы ФЛ: Общебанковские (6, 7, 8, 11)',
                'pl_plugin_33' => 'Тарифы ФЛ: Расчетное обслуживание',
                'pl_plugin_30' => 'Тарифы ФЛ: Сейфовые ячейки',
                'pl_plugin_23' => 'Текст для региона',
                'pl_plugin_19' => 'Телефон Call-центра',
                'pl_plugin_104' => 'Учёт скачивания файлов',
                'pl_plugin_15' => 'Филиалы',
                'pl_plugin_54' => 'Экспресс кредиты',
                'pl_plugin_47' => 'Эмитенты',
                'pl_plugin_90' => 'не активна!  Заявка на звонок(микс)',
                'pl_plugin_44' => 'не активна! Заявка на автокредит по телефону',
                'pl_plugin_91' => 'не активна! Заявка на ипотеку (промо-страница)',
                'pl_plugin_26' => 'не активна! Заявка на кредит для МСБ на сайте',
                'pl_plugin_22' => 'не активна! Заявка на кредит на неотложные нужды',
                'pl_plugin_36' => 'не активна! Заявка на кредит по банковской карте',
                'pl_plugin_84' => 'не активна! Заявка на кредит с сайта КупиКупон',
                'pl_plugin_68' => 'не активна! Заявка на открытие счета МСБ',
                'pl_plugin_99' => 'не активна! Заявка подключить интернет-банк',
                'pl_plugin_86' => 'не активна! Заявки для промо-страницы ПРО',
                'pl_plugin_74' => 'не активна! Заявки на Рефинансирование автокредит',
                'pl_plugin_73' => 'не активна! Заявки на Рефинансирование потреб. кр',
                'pl_plugin_29' => 'не активна! Заявки на автокредит',
                'pl_plugin_80' => 'не активна! Заявки на карты ISIC/IYTC',
                'pl_plugin_75' => 'не активна! Заявки на карты ТРАНСАЭРО-РОСБАНК',
                'pl_plugin_60' => 'не активна! МСБ "Кредит за час"'
            );

            foreach ($m as $m_ident => $title) {
                echo $str = $title . "\r\n", '<br>';
                fwrite($xml_file, $str);
                // Нахожу раздел элемента
                $query = 'SELECT e.e_ident, e.e_link, e.e_p_id, p.p_name, p.p_filepath, p.p_filename FROM sb_elems e LEFT JOIN sb_pages p ON e.e_p_id = p.p_id WHERE e.e_ident LIKE "' . $m_ident . '\_%"';
                $res = sql_assoc($query); // нахожу все компоненты
                if ($res) {
                    $components = array(
                        'form' => array(),
                        'list' => array(),
                        'full' => array(),
                        'filter' => array(),
                        'header_plain' => array(),
                        'header_html' => array(),
                        'categs' => array(),
                        'cloud' => array(),
                        'design' => array(),
                        'profile_design' => array(),
                        'design_list' => array(),
                        'path_html' => array(),
                        'path_plain' => array(),
                        'tree' => array(),
                        'rss' => array(),
                        'sel_cat' => array(),
                        'results' => array(),
                        'data' => array(),
                        'login' => array(),
                        'reg' => array(),
                        'remind' => array(),
                        'update' => array(),
                    );
                    $form_title = array(
                        'form' => 'Форма добавления элементов',
                        'list' => 'Вывод списка элементов',
                        'full' => 'Вывод выбранного элемента',
                        'filter' => 'Форма фильтра элементов',
                        'header_plain' => 'Вывод названия элемента (только текст)',
                        'header_html' => 'Вывод названия элемента (html)',
                        'categs' => 'Вывод разделов',
                        'cloud' => 'Вывод облака тегов',
                        'design' => 'Вывод баннера',
                        'profile_design' => 'Вывод баннера (с профилированием)',
                        'design_list' => 'Вывод списка баннеров',
                        'path_html' => 'Вывод пути по сайту (html)',
                        'path_plain' => 'Вывод пути по сайту (только текст)',
                        'tree' => 'Вывод меню',
                        'rss' => 'Вывод в формате RSS 2.0',
                        'sel_cat' => 'Вывод выбранного раздела',
                        'results' => 'Вывод результатов',
                        'data' => 'Вывод данных пользователя',
                        'login' => 'Вывод формы логина',
                        'reg' => 'Вывод формы регистрации',
                        'remind' => 'Форма напоминания пароля',
                        'update' => 'Форма изменения данных',
                    );
                    foreach ($res as $v) {
                        $ident = str_replace($m_ident . '_', '', $v['e_ident']);
                        if ($v['e_link'] == 'page') {
                            if (!isset($components[$ident]['page'])) $components[$ident]['page'] = array();
                            $url = '' . SB_DOMAIN . '';
                            if (trim($v['p_filepath']) != '') $url .= '/' . $v['p_filepath'];
                            if (trim($v['p_filename']) != '') $url .= '/' . $v['p_filename'];
                            $components[$ident]['page'][$v['e_p_id']] = strip_tags($v['p_name']) . ' (' . $url . ')';
                        }
                        if ($v['e_link'] == 'temp') {
                            if (!isset($components[$ident]['temp'])) $components[$ident]['temp'] = array();
                            $temp = sql_assoc('SELECT t_name FROM sb_templates WHERE t_id = ?d', $v['e_p_id']);
                            if ($temp) $components[$ident]['temp'][$v['e_p_id']] = strip_tags($temp[0]['t_name']);
                        }
                        //echo $v['e_ident'].' '.$v['e_link'].' '.$v['e_p_id']."<br>\r\n";
                    }
                    foreach ($components as $form => $component) {
                        if (count($component) > 0) {
                            if (isset($component['page']) && count($component['page']) > 0) {
                                echo $str = "\t" . "Компонент " . $form_title[$form] . ". Страницы:\r\n", '<br>';
                                fwrite($xml_file, $str);
                                foreach ($component['page'] as $page_id => $page) {
                                    echo $str = "\t" . "\t" . $page_id . ' ' . $page . "\r\n", '<br>';
                                    fwrite($xml_file, $str);
                                }
                            }
                            if (isset($component['temp']) && count($component['temp']) > 0) {
                                echo $str = "\t" . "Компонент " . $form_title[$form] . ". Макеты дизайна сайта:\r\n", '<br>';
                                fwrite($xml_file, $str);
                                foreach ($component['temp'] as $temp_id => $temp) {
                                    echo $str = "\t" . "\t" . $temp_id . ' ' . $temp . "\r\n", '<br>';
                                    fwrite($xml_file, $str);
                                }
                            }
                        }
                    }
                }
                //break;
                echo "\r\n";
            }

            fclose($xml_file);
        }
        if ($_GET['events'] == 'form_fields_moduls') {

            $moduls = array(
                array('name' => 'sb_users', 'title' => 'Пользователи системы'),
                array('name' => 'sb_site_users', 'title' => 'Пользователи сайта'),
                array('name' => 'sb_faq', 'title' => 'Вопрос-Ответ'),
                array('name' => 'sb_sprav', 'title' => 'Справочник'),
            );
            // $moduls = array();

            $plugins = sql_assoc('SELECT pm_id, pm_title FROM sb_plugins_maker');
            if ($plugins) {
                foreach ($plugins as $plugin) {

                    $moduls[] = array('name' => 'sb_plugins_' . $plugin['pm_id'], 'title' => $plugin['pm_title']);

                }
            }
            foreach ($moduls as $modul) {
                echo '<b>' . $modul['title'] . '</b>' . '<br>';
                $fields = sql_assoc('SELECT column_comment, column_name FROM information_schema.columns WHERE TABLE_NAME LIKE "' . $modul['name'] . '"');
                if ($fields) {
                    foreach ($fields as $field) {
                        // if (trim($field['column_comment']) != '') echo "\t".$field['column_comment'].'<br>';
                        echo "\t" . $field['column_name'] . ' => ' . $field['column_comment'] . '<br>';
                    }
                }
            }
        }
        if ($_GET['events'] == 'api') {
            function request($url, $type = 'GET', $raw = array())
            {
                //$token = '1e1a0c2098abe4a06f1c02c7da2b5ba5'; // rosbank.dev.binn.ru
                $token = 'dc26337f701304da2ad357ea0e0e4f5e'; // rosbank.ru
                $c = curl_init($url);
                if ($type == 'POST') {
                    curl_setopt($c, CURLOPT_POST, true);
                    curl_setopt($c, CURLOPT_POSTFIELDS, $raw);
                }
                if ($token) {
                    curl_setopt($c, CURLOPT_HTTPHEADER, array(
                        "X-User-Token: " . $token,
                        "Content-Type: application/json; charset=utf-8",
                        //'If-Modified-Since: ' . date('r', (time()-3600*24)),
                        //'If-Modified-Since: Sun, 26 Jan 2014 02:00:01 +0200',
                        "User-Agent: Test API)"
                    ));
                }
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);

                $request = curl_exec($c);
                curl_close($c);

                return $request;
            }

            $url = 'http://www.rosbank.ru/cms/admin/api/' . (isset($_GET['service']) ? $_GET['service'] : '');
            $params = array(
                'page' => 1,
                'elemPerPage' => 10,
                'filters' => array(
                    //'region' => 34, // Для полей типа множественный выбор,
                    /*'region' => array(//для связанных списков(отделения, банкоматы)
                     'rs_sprav_fo' => 102,
                     'rs_sprav_region' => 34
                     )*/
                    //'cat_ids' => array(66, 67),
                    //'cat_ids' => array(653, 685), // банкоматы
                    //'cat_ids' => array(763),// Новости
                    //'cat_ids' => array(66)//,// Регионы
                    //'cat_ids' => array(86)//,// Метро
                    //'cat_ids' => array(627, 630, 640, 644, 663, 670, 887, 618)
                    //'cat_ids' => array(2773),
                    //'ids' => array(4901, 3925),
                    //'ids' => array(82618), // банкоматы
                    //'date_from' => '1390059400'
                    //'card_types' => array(1, 2)
                ),
            );
            if (isset($_GET['debug'])) {
                $params['debug'] = 1;
            }
            if (isset($_GET['partners'])) {
                $params['partners'] = 1;
            }
            //echo date('d.m.Y H:i');
            //exit;

            header('Content-type: application/json');
            echo request($url, 'POST', json_encode($params));

            function buildPhoneNumber($number = '1234567')
            {
                if (!is_numeric($number))
                    return false;

                echo 1;
                $numbers = preg_split('//u', $number, -1, PREG_SPLIT_NO_EMPTY);
                $numbers = array_reverse($numbers);
                $res = array();
                foreach ($numbers as $i => $num) {
                    if ($i == 2 || $i == 4)
                        $res[] = '-';
                    $res[] = $num;
                }
                $res = implode('', array_reverse($res));

                return $res;
            }
        }

        function dbg($str, $exit = true)
        {
            print_r('<pre style="text-align: left !important;">-');
            print_r($str);
            print_r('-</pre>');
            if ($exit) exit;
        }
    } else {
        $title = 'Техническа поддержка';
        foreach ($a_menu as $a_m) {
            if (isset($_GET['events']) && $_GET['events'] != '' && $a_m['url'] == $_GET['events'] && $_GET['events'] != 'api') $title = $a_m['title'];
        }
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="utf-8">

            <meta name="author" content="BINN, binn.ru">
            <meta name="keywords" content="">
            <meta name="description" content="">

            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <meta name="format-detection" content="telephone=no">

            <link rel="shortcut icon" sizes="32x32" href="favicon.ico" type="image/x-icon">

            <title><?php echo $title; ?></title>

            <style>
                .wrapper {
                    display: flex;
                    height: 100%;
                }

                .left_column {
                    width: 200px;
                }

                .left_column ul {
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }

                .left_column ul li {
                    padding: 5px;
                    border-bottom: 1px solid #bdbdbd;
                }

                .content {
                    margin-left: 20px;
                    flex-basis: 100%;
                }

                .content iframe {
                    width: 100%;
                    height: 100%;
                    border: 0;
                }
            </style>

        </head>
        <body>
        <div class="wrapper">
            <div class="left_column">
                <?php
                $menu = '<ul>';
                foreach ($a_menu as $a_m) {
                    $menu .= '<li><a href="?event=pl_service_sb_init&events=' . $a_m['url'] . '" target="pl_service_content">' . $a_m['title'] . '</a></li>';
                }
                $menu .= '</ul>';
                if (!isset($_GET['events']) || isset($_GET['events']) && $_GET['events'] != 'api') {
                    echo $menu;
                } ?>
            </div>
            <div class="content">
                <iframe name="pl_service_content" src="?event=pl_service_sb_init&events=empty_page"></iframe>
            </div>
        </div>
        </body>
        </html>
    <?php }
}
