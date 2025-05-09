<?php //ny.storage.bunnycdn.com

class nerdyEnt extends ent {
    static $sql_debug = false;
    var $args;
    var $farr = [];
    var $aarr = [];
    var $orderBy = "id DESC";
    var $namedBy = "name";
    var $cache,$pcache;

    /*function collapse($url,$pre="slide_") {
        $hk = "_collapse_".md5("ssshd784j".$pre.$url);
        if(@$this->cache[$hk]) {
            return $this->cache[$hk];
        }
        $ua = explode("/",urldecode($url));
        $tail = $ua[sizeof($ua)-1];
        $ext = @(explode(".",$tail))[1];
        $ext = $ext?strtolower($ext):null;

        $file = urlencode($tail);
        if($pre=="slide_") { //$ext=="jpeg"||$ext=="jpg"||$ext=="png") {
            $bunt = app::http_file_exists("{$this->cache['shu']}/{$pre}$file");
            if(!$bunt) $bunt = app::http_file_exists("{$this->cache['shu']}/$file");
            if(!$bunt) $bunt = app::http_file_exists("{$this->cache['shu']}/{$pre}med_$file");
            if(!$bunt) $bunt = app::http_file_exists("{$this->cache['shu']}/{$pre}large_$file");
        } else {
            $info = parse_url("{$this->cache['shu']}/{$pre}$file");
            $bunt = app::bunnyToken(@$info['path'], @$info['scheme']."://".@$info['host']);
        }

        $this->cache[$hk] = $bunt;
        $this->pcache->action("assert",$this->cache);
        return $bunt;
    } */

    static function connect() {
        return new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function delete($id) {
        return $this->ft("DELETE FROM ".$this->key." WHERE id=?","i",[$id]);
    }

    protected function ft($sql,$types=null,$prms=null) {
        $my = self::connect();
        if(!$types) {
            try {
                //echo $sql;
                $ret = $my->query($sql);
                if($ret) {
                    return $ret;
                } else {
                    if((DEV || self::$sql_debug)) {
                        echo "ERROR:[$sql] ".mysqli_error($my);
                    }
                }
            } catch (Exception $e) {
                if((DEV || self::$sql_debug)) {
                    echo "ERROR:[$sql] ".mysqli_error($my);
                }
            }
        } else {
            $st = $my->prepare($sql);
            if((DEV || self::$sql_debug) && !$st) {
                echo "ERROR:[$sql] ".mysqli_error($my);
            }
            $st->bind_param($types, ...$prms);
            $st->execute();
            $res = $st->get_result();
            /*if((DEV || self::$sql_debug) && !$res) {
                echo "ERROR:[$sql] ".mysqli_error($my);
            }*/
            return $res;
        }
    }

    protected function Ins($sql,$types=null,$prms=null) {
        $my = self::connect();
        if(!$types) {
            try {
                $ret = $my->query($sql);
                return $my->insert_id;
            } catch (Exception $e) {
                if((DEV || self::$sql_debug)) {
                    echo "ERROR:[$sql] ".mysqli_error($my);
                }
            }
        } else {
            $st = $my->prepare($sql);
            if((DEV || self::$sql_debug) && !$st) {
                echo "ERROR:[$sql] ".mysqli_error($my);
            }
            $st->bind_param($types, ...$prms);
            $st->execute();
            return $my->insert_id;
        }
    }

    function __construct($table,$group,$args) {
        parent::__construct($table,$group);
        $this->args = $args;

        $this->pcache = new option("optEntCache", "storage");
        $this->cache = $this->pcache->fetch("vals");

        $sett = (new option("optBunny", "storage"))->fetch("vals");
        $this->cache['shu'] = @$sett['http_url'];

        $this->farr['raw'] = function ($sql) {
            return $this->ft($sql);
        };

        $this->farr['all'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM ".$this->key.$wh." ORDER BY ".$this->orderBy);
        };

        $this->farr['array'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            $base = $this->ft("SELECT * FROM ".$this->key.$wh." ORDER BY ".$this->orderBy)->fetch_all(MYSQLI_ASSOC);
            foreach($base as $k=>&$v) {
                $v = str_replace("<","[[",$v);
                $v = str_replace(">","]]",$v);
            }
            return $base;
        };

        $this->farr['id'] = function ($id) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE id=?","i",[$id])->fetch_array();
        };

        $this->farr['by'] = function ($name,$value) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE $name=?","s",[$value])->fetch_array();
        };

        $this->farr['byci'] = function ($name,$value) {
            $value = str_replace(["*","?","%"], "", $value);
            return $this->ft("SELECT * FROM ".$this->key." WHERE $name LIKE ?","s",[$value])->fetch_array();
        };

        $this->farr['options'] = function () {
            $arr = $this->fetch("array");
            $ret = [];
            foreach($arr as $r) {
                $ret []= $r[0];
            }
            return $ret;
        };

        $this->aarr['assert'] = function ($arr=null) {
            //if(!$src) $src = "ausr:".app::adminUser().":aus_name";
            if(!$arr) {
                $arr = app::post("?");
                // $target = "person:".app::request("_id").":per_name";
                $prev = $this->fetch("id",app::request("_id"));
            } else {
                //if(isset($arr['target'])) $target = $arr['target'];
                if(isset($arr['id'])) {
                    $eid = $arr['id'];
                    $prev = $this->fetch("id",$eid);
                } else {
                    $prev = null;
                }
            }

            if(($this->key == "adm" || $this->key == "usr") && isset($arr['password'])) {                
                if($arr['password']=="********") unset($arr['password']);
                else $arr['password']=password_hash($arr['password'], PASSWORD_DEFAULT);                
            }

            $tbl = $this->key;
            $pre = "";
            $idf = $mf = "id";

            if($prev) {
                //$arr["updated"] = date("Y-m-d H:i:s");
                //$arr["update_src"] = $src;

                $eid = $prev["id"];
                /* $prev_data = @json_decode($prev[$pre."previous"],true);
                 if(!$prev_data) $prev_data = [];
                 $nprev = [];
                 $same = true;
                 foreach($this->cols->items('data') as $k) {
                     if($k=="target" || strpos($k,'|')!==false) continue;

                     $nprev[$pre.$k] = $prev[$pre.$k];
                     if($prev[$pre.$k]!=@$arr[$k]) $same = false;
                 }
                 if($same) return $eid;

                 $prev_data[time()."|".$src] = $nprev;*/

                $sets = "";
                $types = "";
                $prms = [];
                foreach ($arr as $k=>$v) {
                    $k = app::slug($k);
                    $k = $pre.$k;
                    if($k==$idf) continue;

                    $sets .= ",$k=?";

                    if(is_float($v)) {
                        $types .= "d";
                        $prms []= $v;
                    } else {
                        $types .= "s";
                        $prms []= $v==""?null:$v;
                    }
                }
                $sets = trim(substr($sets, 1));
                if($sets!="") {
                    $types .= "i";
                    $prms []= $eid;
                    $this->ft("UPDATE $tbl SET $sets WHERE id=?",$types,$prms);
                    //@$this->ft("UPDATE $tbl SET {$this->prefix}previous=? WHERE $mf=?","ss",[json_encode($prev_data),$eid]);
                }
            } else {
                if(in_array("created",$this->cols->items)) $arr["created"] = time();
                //$arr["create_src"] = $src;
                //    $eid = $this->newID();
                $values = "";
                $cols = "";
                if(isset($target)) {
                    $types = "s";
                    $prms = [$target];
                } else {
                    $types = "";
                    $prms = [];
                }
                foreach ($arr as $k=>$v) {
                    $k = app::slug($k);
                    $k = $pre.$k;
                    if($k==$idf) continue;

                    $values .= ",?";
                    $cols .= ",$k";

                    if(is_float($v)) {
                        $prms []= $v;
                        $types .= "d";
                    } else {
                        $types .= "s";
                        $prms []= $v==""?null:$v;
                    }
                }
                if(isset($target)) {
                    $eid = $this->Ins("INSERT INTO $tbl({$pre}target{$cols}) VALUES(?$values)",$types,$prms);
                } else {
                    $cols = substr($cols, 1);
                    $values = substr($values, 1);
                    $eid = $this->Ins("INSERT INTO $tbl($cols) VALUES($values)",$types,$prms);
                }
                //var_dump($ir = $this->ft("SELECT LAST_INSERT_ID()")->fetch_array());
                //$eid = $ir[0];
            }

            return $eid;
        };
    }

    function fetch($key,...$args) {
        return $this->farr[$key](...$args);
    }

    function action($key,...$args) {
        return $this->aarr[$key](...$args);
    }

    function count() {
        $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
        return $this->ft("SELECT COUNT(id) FROM ".$this->key.$wh)->fetch_all()[0][0];
    }

    function sum($k) {
        $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
        return $this->ft("SELECT SUM($k) FROM ".$this->key.$wh)->fetch_all()[0][0];
    }

    function cell($key,$a) {
        switch($key) {
            case "created":
                return date("m/d/Y",$a[$key]);
            default:
                return parent::cell($key, $a);
        }
    }

    function meta($a,$key) {
        switch($key) {
            case "link":
                return VDIR.substr(app::currentUrl(),1)."?_id=$a[id]";
            default:
                return @$a[$key];
        }
    }
}

class pushUsers extends nerdyEnt {
    function __construct($args = [])
    {
        parent::__construct(self::class, "pushUsers", $args);

        $this->cols = new labelledSet(['endpoint', 'expirationTime', 'p256dhKey', 'authKey']);
        $this->orderBy = "id";
        $this->namedBy = "id";
    }
}

class jsonEnt extends ent {
    var $args;
    var $farr = [];
    var $aarr = [];

    public function __construct($key, $group) {
        parent::__construct($key, $group);

        $this->farr['vals'] = $this->farr['id'] = function ($id=null) {
            $eid = $this->key;
            $fn = md5("ooh$eid");
            return @json_decode(file_get_contents(DATA_CONTENT_DIR."/$fn.json"),true);
        };

        $this->aarr['assert'] = function ($arr=null) {
            $eid = $this->key;
            $fn = md5("ooh$eid");

            if(!$arr) $arr = app::post("?");

            $raw = json_encode($arr);
            file_put_contents(DATA_CONTENT_DIR."/$fn.json", $raw);
            return $eid;
        };
    }

    function fetch($key,...$args) {
        return $this->farr[$key](...$args);
    }

    function action($key,...$args) {
        return $this->aarr[$key](...$args);
    }

    function meta($a,$key) {
        switch($key) {
            default:
                return @$a[$key];
        }
    }
}

class video extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct(self::class,"video",$args);

        $this->cols = new labelledSet([ "seo_url","title","sexuality","category","show_on_homepage","poster_url","video_url",
            "duration","description","tags","models","release_date","quality",
            "likes","dislikes","views","publish_status","process_status","created","premuim_member_view_price","free_member_view_price"  ]);
        //$this->orderBy = "id DESC";
        $this->namedBy = "title";
        
        $this->aarr['set-working-attrs'] = function ($home,$name) {
            $a = $this->fetch("inprocess",$home,$name);
            if($a) {
                $att = @json_encode(app::get_video_attributes("/content/usr/$home/working_orig_$name.__mp4"));
                if($att) return $this->action("assert",['id'=>$a['id'],'attributes'=>$att]);
            }
        };
        
        $this->farr['inprocess'] = function ($home,$name,$trailertoo=false) {
            $ret = $this->ft("SELECT * FROM ".$this->key." WHERE IFNULL(video_url,'')='$home/$name'")->fetch_assoc();
            if(!$ret&&$trailertoo) {
                $name = substr($name,8);
                $ret = $this->ft("SELECT * FROM ".$this->key." WHERE IFNULL(trailer_url,'')='$home/$name'")->fetch_assoc();
            }
            return $ret;
        };

        $this->farr['valid'] = function () {
            $wh = isset($this->args["where"])?" WHERE IFNULL(video_url,'')!='' AND ({$this->args['where']}) ":" WHERE IFNULL(video_url,'')!='' ";
            return $this->ft("SELECT * FROM ".$this->key.$wh." ORDER BY ".$this->orderBy)->fetch_all(MYSQLI_ASSOC);
        };

        $this->farr['popular'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM video LEFT OUTER JOIN urating on vid_id=video.id $wh GROUP BY video.id,urating.id ORDER BY SUM(rating) DESC")->fetch_all(MYSQLI_ASSOC);
        };
        
        $this->farr['categories'] = function () {
            $oent = new category;
            $cats = $oent->fetch("array");
            $ret = [];
            foreach($cats as $c) {
                $rs = $this->ft("SELECT * FROM video WHERE category LIKE '%$c%'")->fetch_all(MYSQLI_ASSOC);
                if(sizeof($rs)>0) {                    
                    $gr = $rs[random_int(0, sizeof($rs)-1)];
                    $gr['_tagline'] = $c;
                    $ret[]=$gr;
                }
            }            
            return $ret;
        };
        
        $this->farr['video-tags'] = function () {
            $oent = new tag;
            $tags = $oent->fetch("array");
            $ret = [];
            foreach($tags as $c) {                
                $rs = $this->ft("SELECT * FROM video WHERE tags LIKE '%$c%'")->fetch_all(MYSQLI_ASSOC);
                if(sizeof($rs)>0) {                    
                    $gr = $rs[random_int(0, sizeof($rs)-1)];
                    $gr['_tagline'] = $c;
                    $ret[]=$gr;
                }
            }            
            return $ret;
        };
        
        $this->farr['tags'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM video LEFT OUTER JOIN urating on vid_id=video.id $wh GROUP BY video.id,urating.id ORDER BY SUM(rating) DESC")->fetch_all(MYSQLI_ASSOC);
        };

        $this->farr['oldest'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM video $wh ORDER BY release_date ASC")->fetch_all(MYSQLI_ASSOC);
        };

        $this->farr['newest'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM video $wh ORDER BY release_date DESC")->fetch_all(MYSQLI_ASSOC);
        };

        $this->farr['linked'] = function ($url) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE seo_url=?","s",[$url])->fetch_array();
        };

        $this->farr['allfav'] = function ($mid) {
            $wh = isset($this->args["where"])?" WHERE ({$this->args['where']}) AND (rating>0 AND usr_id=?)":" WHERE rating>0 AND usr_id=?";
            return $this->ft("SELECT * FROM ".$this->key." LEFT OUTER JOIN urating ON vid_id=video.id $wh ORDER BY created DESC","i",[$mid])->fetch_all(MYSQLI_ASSOC);
        };
    }

    function meta($a,$key) {
        switch($key) {            
            case 'process-key':
                return $a['title'];
            case "att":
                $ret = @json_decode($a['attributes'],true);                
                if(!$ret) $ret = ["width"=>"1280","height"=>"720","hours"=>"00","mins"=>"30","secs"=>"00"];
                return $ret;
            case "effprice":
                return app::memberRole() == 'Free'?$a['free_member_view_price']:$a['premium_member_view_price'];
            case "liveshow":
                return !empty($a['casting_on'])?"now":false;//now|soon|archive                
            case "small-poster":
                $ua = explode("/",$a['poster_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "small_".$ua[sizeof($ua)-1];
                $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0 && !app::http_file_exists($path)) {
                    $ua[$sz-1] = "slide_".$ua[$sz-1];
                    $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                }
                return app::secure_asset($path);
            case "trailer":             
                if(empty($a['trailer_url'])) return null;
                $ua = explode("/",$a['trailer_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "standard_hd_trailer_".$ua[sizeof($ua)-1]."__.mp4";
                return app::secure_asset(app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]])));                                
            case "hd":
                if(empty($a['video_url'])) return VDIR."loading.mp4";
                $ua = explode("/",$a['video_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "standard_hd_".$ua[sizeof($ua)-1]."__.mp4";
                return app::secure_asset(app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]])));
            case "orig":
                if(empty($a['video_url'])) return VDIR."loading.mp4";
                $ua = explode("/",$a['video_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "standard_orig_".$ua[sizeof($ua)-1]."__.mp4";
                return app::secure_asset(app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]])));
            case "preview":
                if(!empty($a['trailer_url'])) return $this->meta($a, "trailer");
                if(empty($a['video_url'])) return VDIR."loading.mp4";
                $ua = explode("/",$a['video_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "standard_preview_".$ua[sizeof($ua)-1]."__.mp4";
                return app::secure_asset(app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]])));
            case "abs-preview":
                $url = $this->meta($a, "preview");
                return strpos($url,"://")===false?DOM.$url:$url;
            case "poster":
                if(empty($a['poster_url'])) return VDIR."loading.jpg";
                $v = $a['poster_url'];
                $ua = explode("/",$a['poster_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = str_replace("med_","large_",$ua[sizeof($ua)-1]);
                if(strpos($ua[sizeof($ua)-1],"slide_")!==0 && strpos($ua[sizeof($ua)-1],"med_")!==0 && strpos($ua[sizeof($ua)-1],"large_")!==0 && strpos($ua[sizeof($ua)-1],"small_")!==0)  $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
                $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0 && !app::http_file_exists($path)) {
                    $ua[$sz-1] = "slide_".$ua[$sz-1];
                    $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                }
                return app::secure_asset($path);
            case "small-background":
                /*$ua = explode("/",urldecode($a['poster_url']));
                $ua[sizeof($ua)-1] = "small_".$ua[sizeof($ua)-1];
                $url = urlencode(implode("/", $ua));
                return "background-position: top center;background-size: cover; background-image: url('". $this->collapse($url,"slide_")."');";                */
                if(empty($a['poster_url'])) return VDIR."loading.jpg";
                $v = $a['poster_url'];
                $ua = explode("/",$a['poster_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = str_replace("med_","small_",$ua[sizeof($ua)-1]);
                if(strpos($ua[sizeof($ua)-1],"slide_")!==0 && strpos($ua[sizeof($ua)-1],"med_")!==0 && strpos($ua[sizeof($ua)-1],"large_")!==0 && strpos($ua[sizeof($ua)-1],"small_")!==0)  $ua[sizeof($ua)-1] = "small_".$ua[sizeof($ua)-1];
                $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0 && !app::http_file_exists($path)) {
                    $ua[$sz-1] = "slide_".$ua[$sz-1];
                    $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));                    
                }
                $url = app::secure_asset($path);
                return "background-image:url('$url');background-position:center center;background-size:cover;";
            case "background":
                if(empty($a['poster_url'])) return VDIR."loading.jpg";
                //echo $a['poster_url'];

                //$v = $a['poster_url'];
                $ua = explode("/",$a['poster_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = str_replace("med_","large_",$ua[sizeof($ua)-1]);
                if(strpos($ua[sizeof($ua)-1],"slide_")!==0 && strpos($ua[sizeof($ua)-1],"med_")!==0 && strpos($ua[sizeof($ua)-1],"large_")!==0 && strpos($ua[sizeof($ua)-1],"small_")!==0)  $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
                $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0 && !app::http_file_exists($path)) {
                    $ua[$sz-1] = "slide_".$ua[$sz-1];
                    $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                }
                $url = app::secure_asset($path);
                return "background-image:url('$url');background-position:center center;background-size:cover;";
            case "med-background":
                if(empty($a['poster_url'])) return VDIR."loading.jpg";
                $v = $a['poster_url'];
                $ua = explode("/",$a['poster_url']);
                $sz = sizeof($ua);
                if(strpos($ua[sizeof($ua)-1],"slide_")!==0 && strpos($ua[sizeof($ua)-1],"med_")!==0 && strpos($ua[sizeof($ua)-1],"large_")!==0 && strpos($ua[sizeof($ua)-1],"small_")!==0) $ua[sizeof($ua)-1] = "med_".$ua[sizeof($ua)-1];

                //if(strpos($ua[sizeof($ua)-1],"med_")!==0) $ua[sizeof($ua)-1] = "med_".$ua[sizeof($ua)-1];
                $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0 && !app::http_file_exists($path)) {
                    $ua[$sz-1] = "slide_".$ua[$sz-1];
                    $path = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                }
                $url = app::secure_asset($path);                
                return "background-image:url('$url');background-position:center center;background-size:cover;";
            case "abs-poster":
                //if(empty($a['poster_url'])) return VDIR."loading.jpg";
                //$url = $a['poster_url'];
                //$ua = explode("/",$a['poster_url']);
                //$sz = sizeof($ua);
                //$ua[sizeof($ua)-1] = "med_".$ua[sizeof($ua)-1];
                //if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                //$url = app::secure_asset(app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]])));
                //return DOM.VDIR."content/usr/$url";
                $url = $this->meta($a, "poster");
                return strpos($url,"://")===false?DOM.$url:$url;
            case "label":
                $ret = $a['title'];
                return strlen($ret)>25?substr($ret, 0,22)."...":$ret;
            case "tag":
                return $a['release_date']." - ".$a['duration']."[$a[publish_status]]";
            case "abs-player_url":
                return DOM.VDIR."video?_video=".$a['seo_url'];
            case "player_url":
                return VDIR."video?_video=".$a['seo_url'];
            case "release_date_iso":
                return date('R', strtotime($a['release_date']));
            case "family_friendly":
                return 'No';
            case "duration_secs":
                $att = json_decode($a['attributes'],true);
                if(!$att) return null;
                return @$att['hours']*3600+@$att['mins']*60+@$att['secs'];
            default:
                @list($pk,$idx) = explode(":", $key);
                if(is_numeric($idx)) {
                    switch($pk) {
                        case "scene_url":                            
                        case "scene":
                            $ret = null;
                            $va = explode("/", explode("?", $a['video_url'])[0]); 
                            $ids = sprintf("%03d",$idx);
                            if(($sz = sizeof($va))>1) {        
                                $file = $va[$sz-2]."/slides/med_".urlencode($va[$sz-1]."__$ids.jpg");                                                                        
                                $ua = explode("/",$file);
                                $sz = sizeof($ua);
                                //$ua[sizeof($ua)-1] = str_replace("med_","small_",$ua[sizeof($ua)-1]);
                                if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                                $ret = app::secure_asset($url);
                            } 
                            if(!$ret) return null;
                            if($pk=="scene") return $ret;
                            return VDIR."gallery?_video=$a[seo_url]&_idx=$idx&_ty=scene";
                        case "gvl_url":                
                            $idx-=1;
                        case "gvl":
                            $ret = null;
                            $gvl = @json_decode(@$a['image_gallery'],true);
                            if($gvl && !empty(@$gvl[$idx])) {
                                $ua = explode("/",$gvl[$idx]);
                                $sz = sizeof($ua);
                                //$ua[sizeof($ua)-1] = str_replace("med_","small_",$ua[sizeof($ua)-1]);
                                //if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-3],"slides",$ua[$sz-1]]));
                                $ret = app::secure_asset($url);                              
                            } 
                            if(!$ret) return null;
                            if($pk=="gvl") return $ret;                            
                            $idx+=1;
                            return VDIR."gallery?_video=$a[seo_url]&_idx=$idx&_ty=gvl";
                    }                                                    
                } else {
                    return parent::meta($a,$key);
                }
        }
    }
}

class model extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct(self::class,"models",$args);

        $this->cols = new labelledSet([ "biopic_url","banner_url","model_name","gender","sexuality","place_of_birth","description" ]);
        $this->orderBy = "model_name";
        $this->namedBy = "model_name";
        
        $this->farr['options'] = function () {
            $arr = $this->ft("SELECT model_name AS name FROM ".$this->key. " ORDER BY ".$this->orderBy)->fetch_all();
            $ret = [];
            foreach($arr as $r) {
                $ret []= $r[0];
            }                        
            return $ret;
        };

        $this->farr['named'] = function ($name) {
            if(is_array($name)) {
                $nn = [];
                $my = self::connect();
                foreach($name as $n) {
                    $nn []= $my->real_escape_string($n);
                }
                return $this->ft("SELECT * FROM ".$this->key." WHERE model_name IN ('".implode("','",$nn)."')")->fetch_all(MYSQLI_ASSOC);
            } else {
                return $this->ft("SELECT * FROM ".$this->key." WHERE model_name LIKE ?","s",[$name])->fetch_array();
            }
        };

        $this->farr['allfav'] = function ($mid) {
            $wh = " WHERE (sexuality='Straight'AND publish_status='Published') AND (rating>0 AND usr_id=?)";
            $mod = $this->ft("SELECT models FROM video LEFT OUTER JOIN urating ON vid_id=video.id $wh","i",[$mid])->fetch_all(MYSQLI_ASSOC);
            $names = [];
            foreach($mod as $m) {
                $ma = explode(",",$m['models']);
                foreach($ma as $mi) if(!in_array($mi,$names)) $names []= $mi;
            }
            return $this->fetch("named",$names);
        };
    }

    function meta($a,$key) {
        switch($key) {
            case "med-background":
                $ua = explode("/",$a['biopic_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "med_".$ua[sizeof($ua)-1];
    //            if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]]));
                //$url = urlencode(implode("/", $ua));
                return "background-position: top center;background-size: cover; background-image: url('$url');";
            case "small-background":
                $ua = explode("/",$a['biopic_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "small_".$ua[sizeof($ua)-1];
    //            if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                //$url = urlencode(implode("/", $ua));
                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]]));
                return "background-position: top center;background-size: cover; background-image: url('$url');";
            case "background":
                $ua = explode("/",$a['biopic_url'] ?? '');
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
     //           if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                //$url = urlencode(implode("/", $ua));
                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]]));
                return "background-position: top center;background-size: cover; background-image: url('$url');";
            case "banner":
                $ua = explode("/",$a['banner_url']);
                $sz = sizeof($ua);
                $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
      //          if(app::$storage!="local" && strpos($ua[$sz-1],"slide_")!==0) $ua[$sz-1] = "slide_".$ua[$sz-1];
                //$url = urlencode(implode("/", $ua));
                $url = app::$assetPath.(app::$storage!="local"?$ua[$sz-1]:implode("/", [$ua[$sz-2],$ua[$sz-1]]));
                return "background-position: top center;background-size: cover; background-image: url('$url');";
            case "avatar":
                return $a['biopic_url'];
            case "seo-name":
                $ret = $a['model_name'];
                return app::slug($ret, "-");
            case "label":
                $ret = $a['model_name'];
                return strlen($ret)>25?substr($ret, 0,22)."...":$ret;
            case "tag":
                return $a['gender']." / ".$a['sexuality'];
            case "poster":
                $ua = explode("/",$a['biopic_url']);
                $ua[sizeof($ua)-1] = "med_".$ua[sizeof($ua)-1];
            //$url = urlencode(implode("/", $ua));
            //return VDIR."serve?url=$url";
            default:
                return parent::meta($a, $key);
        }
    }
}

class member extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("usr","members",$args);

        $this->cols = new labelledSet([ "sso_token","created_date","profile_img","username","email","mobile","wallet_balance","password","last_login_ip","last_login_country","last_login_at", "signup_domain","active","banned","urole" ]);
        $this->cols->not['listable'] = ["sso_token","password","profile_img"];
        $this->singular = "member";
        $this->plural = "members";
        $this->orderBy = "username";
        
        $this->aarr['wallet_debit'] = function ($mid,$price) {
            if($mid>0) return $this->ft("UPDATE $this->key SET wallet_balance = wallet_balance - $price WHERE id=$mid");
        };

        $this->farr['md5'] = function ($salt,$hash) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE MD5(CONCAT('$salt',id))=?","s",[$hash])->fetch_array();
        };
    }
    function meta($a,$key) {
        switch($key) {
            case "avatar": 
                if(empty($a['profile_img'])) return "/themes/common/avatar-user.png";
                if(strpos($a['profile_img'],"://")!==false) {
                    return $a['profile_img'];
                } else {
                    return VDIR."content/usr/".app::homeDir()."/".$a['profile_img'];
                }
        }
    }
}

class catalog extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("citem","sales",$args);

        $this->cols = new labelledSet([ "item_name","item_tip","item_desc","item_dur","item_type","vendo_code","aquete_code","wallet_value" ]);
        $this->cols->labels['aquete_code'] = "Price Point";
        $this->cols->not['listable'] = ["item_desc"];
        $this->singular = "catalog item";
        $this->plural = "catalog items";
    }
}

class transaction extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("usr_trans","sales",$args);

        $this->cols = new labelledSet([ "username","tuser_id","tref","tamount","tstatus","tdatetime","ttype","tinfo","prov","citem_id","prov_json" ]);
        $this->cols->not['listable'] = ["tuser_id","prov_json"];
        $this->cols->not['user-listable'] = ["tuser_id","prov_json","prov"];

        $this->singular = "transaction";
        $this->plural = "transactions";

        $this->farr['all'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM ".$this->key." JOIN usr ON tuser_id=usr.id "  .$wh." ORDER BY $this->key.".$this->orderBy);
        };
        $this->farr['for_member'] = function ($mid) {
            $wh = "WHERE tuser_id='$mid'";
            return $this->ft("SELECT * FROM ".$this->key." JOIN usr ON tuser_id=usr.id "  .$wh." ORDER BY $this->key.".$this->orderBy);
        };
        $this->farr['array'] = function () { return $this->farr['all']()->fetch_all(MYSQLI_ASSOC); };
    }
}

class domain extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("label","system",$args);

        $this->cols = new labelledSet([ "domain_match","domain_name","site_title","copyright_name","sexuality","meta_tags","logo_url","background_color","text_color","button_color","line_color","custom_css","custom_homepage","custom_register_video_url","custom_head_code" ]);
        $this->cols->not['listable'] = ["custom_css","custom_head_code","custom_register_video_url","meta_tags","logo_url","text_color","button_color","line_color","background_color"];

        $this->singular = "domain";
        $this->plural = "domains";
    }
}

class category extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("video","video",$args);
        $this->cols = new labelledSet([ "category"]);

        $this->farr['array'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            $arr = $this->ft("SELECT DISTINCT(category) as name FROM ".$this->key.$wh." ORDER BY name")->fetch_all(MYSQLI_ASSOC);
            $ret = [];
            foreach($arr as $a) {
                if(empty($a['name'])) continue;
                $ta = explode(",",$a['name']);
                foreach($ta as $t) {
                    $t=trim($t);
                    if(empty($t)) continue;

                    $ret[$t]=$t;
                }                
            }
            
            return $ret;
        };

        $this->farr['options'] = function () {
            return $this->fetch("array");
        };

        $this->farr['id'] = function () {
            $arr = $this->fetch("array");
            return ["categories"=>implode(",", $arr)];
        };
    }
}

class tag extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("tag","video",$args);
        /*
         *         $this->cols = new labelledSet([ "tag_name"]);
                $this->orderBy = "tags";
                $this->namedBy = "tags";
         */
        $this->farr['options'] = function () {
            return $this->fetch("array");
        };

        $this->farr['array'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            $q = $this->ft("SELECT tags FROM video WHERE publish_status='Published'");
            $arr = [];
            while($a=$q->fetch_array()) {
                $ta = explode(",",$a['tags']);
                foreach($ta as $t) {
                    $t=trim($t);
                    if(empty($t)) continue;

                    $arr[$t]=$t;
                }
            }

            return $arr;
        };

        $this->farr['id'] = function () {
            $arr = $this->fetch("array");
            return ["tags"=>implode(",", $arr)];
        };
    }
}

class emTemplate extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("em_template","system",$args);

        $this->cols = new labelledSet([ "email_subject","tpl_key","body" ]);
        $this->cols->not['listable'] = ["body"];

        $this->singular = "email template";
        $this->plural = "email templates";
    }
}

class customMenuItem extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("custom_menu_item","content",$args);

        $this->cols = new labelledSet([ "title","url" ]);

        $this->singular = "custom menu item";
        $this->plural = "custom menu items";
    }
}

class customPage extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("custom_page","content",$args);

        $this->cols = new labelledSet([ "hook","page_title","alias_of","aliased_header","body","keywords","description" ]);
        $this->cols->not["listable"] = ["body"];

        $this->singular = "custom page";
        $this->plural = "custom pages";
    }
}

class theme extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("theme","apperance",$args);

        $this->cols = new labelledSet([ "light_mode","custom_css" ]);

        $this->singular = "theme";
        $this->plural = "themes";

//        $this->farr['id'] = function ($id) {
        //          return @$this->ft("SELECT * FROM ".$this->key." WHERE id=1")->fetch_assoc();
        //    };

        $this->farr['id'] = function ($id) {
            $ret = $this->ft("SELECT * FROM ".$this->key)->fetch_assoc();
            if(!$ret) {
                $this->action("assert",["custom_css"=>""]);
                $ret = $this->ft("SELECT * FROM ".$this->key)->fetch_assoc();
            }
            return $ret;
        };

    }
}

class blog extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("blog","blog",$args);

        $this->cols = new labelledSet([ "title","slug","body","tags","member_id","keywords","description" ]);
        $this->cols->not['listable'] = ['body','member_id'];
        $this->singular = "blog post";
        $this->plural = "blog posts";
        $this->namedBy = "tags";
    }

    function meta($a,$key) {
        switch($key) {
            case "creator":
                return "NerdyCMSAdmin";
            case "poster":
                //return "/research/serve?url=large_". urlencode($a['featured_image']);
                $ua = explode('/',$a['featured_image']);
                $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
                return "/serve?url=".implode("/",$ua);
            default:
                return parent::meta($a, $key);
        }
    }
}

class message extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("msg","content",$args);

        $this->cols = new labelledSet(["msg","incoming_msg_id","outgoing_msg_id"]);
        $this->cols->not['listable'] = ['msg'];
        $this->singular = "message";
        $this->plural = "messages";
        $this->namedBy = "msg";
    }
}

class announce extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("ann","content",$args);

        $this->cols = new labelledSet(["msg_id","target_id","been_read"]);
        $this->singular = "announcment";
        $this->plural = "announcements";
        $this->namedBy = "target_id";
    }
}

class mref extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("mref","members",$args);

        $this->cols = new labelledSet(["from_id","new_mem_id","stamp"]);
        $this->singular = "referral";
        $this->plural = "referral";
        $this->namedBy = "new_mem_id";

        $this->farr['for'] = function ($id) {
            return $this->ft("SELECT * FROM ".$this->key." JOIN usr ON new_mem_id=usr.id WHERE from_id=? ORDER BY username","i",[$id])->fetch_all(MYSQLI_ASSOC);
        };
    }
}

class smsBody extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("sbdy","members",$args);

        $this->cols = new labelledSet(["body"]);
        $this->singular = "SMS body";
        $this->plural = "SMS bodies";
        $this->namedBy = "body";
    }
}

class option extends jsonEnt {

}

class trailer extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("trail","trailers",$args);

        $this->cols = new labelledSet([ "label","poster_url","video_url","enabled" ]);
        $this->orderBy = "label";
        $this->namedBy = "label";

    }

    function meta($a,$key) {
        switch($key) {
            case "video":
                $ua = explode("/",$a['video_url']);
                $ua[sizeof($ua)-1] = "hd_".$ua[sizeof($ua)-1]."__.mp4";
                return VDIR."serve?url=". urlencode(implode("/", $ua));
            case "preview":
                $ua = explode("/",$a['video_url']);
                $ua[sizeof($ua)-1] = "preview_".$ua[sizeof($ua)-1]."__.mp4";
                return VDIR."serve?url=". urlencode(implode("/", $ua));
            case "poster":
                $ua = explode("/",$a['poster_url']);
                $ua[sizeof($ua)-1] = "large_".$ua[sizeof($ua)-1];
                $url = urlencode(implode("/", $ua));
                return VDIR."serve?url=$url";
            default:
                return parent::meta($a,$key);
        }
    }
}

class resetIntent extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("pwd_reset","system",$args);

        $this->cols = new labelledSet(["usr_id","token","expires"]);
        $this->singular = "password reset";
        $this->plural = "password resets";
        $this->namedBy = "usr_id";

        $this->aarr['tidy'] = function () {
            //return $this->ft("DELETE FROM ".$this->key." WHERE expires < ".time());
        };
    }
}

class urating extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("urating","members",$args);

        $this->cols = new labelledSet(["usr_id","rating","vid_id"]);
        $this->singular = "user rating";
        $this->plural = "user ratings";
        $this->namedBy = "usr_id";



        $this->farr['existing'] = function ($vid,$mid) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE usr_id=? AND vid_id=?","ii",[$mid,$vid])->fetch_assoc();
        };

        $this->farr['avg'] = function ($vid) {
            $likes = $this->ft("SELECT SUM(rating) as _v FROM ".$this->key." WHERE rating>0 AND vid_id=?","i",[$vid])->fetch_assoc()['_v'];
            $total = $this->ft("SELECT COUNT(rating) as _v FROM ".$this->key." WHERE vid_id=?","i",[$vid])->fetch_assoc()['_v'];
            if($total==0) return 1;

            return $likes/$total;
        };
    }
}

class ucomment extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("ucomment","members",$args);

        $this->cols = new labelledSet(["usr_id","comment","vid_id"]);
        $this->singular = "user comment";
        $this->plural = "user comments";
        $this->namedBy = "id";
        $this->orderBy = "id";

        $this->farr['existing'] = function ($vid,$mid) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE usr_id=? AND vid_id=?","ii",[$mid,$vid])->fetch_assoc();
        };
    }
}

class adm extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("adm","admins",$args);

        $this->cols = new labelledSet([ "profile_img","username","email","mobile","password","last_login_ip","last_login_country","last_login_at", "active" ,"access" ]);
        $this->cols->not['listable'] = ["password","profile_img"];
        $this->singular = "admin";
        $this->plural = "admins";
        $this->orderBy = "username";

        $this->farr['md5'] = function ($salt,$hash) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE MD5(CONCAT('$salt',id))=?","s",[$hash])->fetch_array();
        };
    }
    function meta($a,$key) {
        switch($key) {
            case "avatar":
                if(empty($a[['profile_img']])) return "/themes/common/avatar-user.png";
                if(strpos($a['profile_img'],"://")!==false) {
                    return $a['profile_img'];
                } else {
                    return VDIR."content/usr/".app::homeDir()."/".$a['profile_img'];
                }
        }
    }
}

class walletTransaction extends nerdyEnt {
    function __construct($args=[]) {
        parent::__construct("wal_trans","sales",$args);

        $this->cols = new labelledSet([ "tdatetime","tuser_id","tref","tamount","tstatus","ttype","tinfo","pitem_id","pitem_type" ]);
        $this->cols->not['listable'] = ["tuser_id"];
        $this->cols->not['user-listable'] = ["tuser_id"];

        $this->singular = "wallet transaction";
        $this->plural = "wallet transactions";

        $this->farr['all'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM ".$this->key." JOIN usr ON tuser_id=usr.id "  .$wh." ORDER BY $this->key.".$this->orderBy);
        };
        $this->farr['own'] = function ($ptype,$pid,$mid) {
            if($this->ft("SELECT * FROM ".$this->key." WHERE pitem_type='$ptype' AND pitem_id='$pid' AND tuser_id='$mid'")->fetch_assoc()) return true;
            else return false;
        };
        $this->farr['for_member'] = function ($mid) {
            $wh = "WHERE tuser_id='$mid'";
            return $this->ft("SELECT * FROM ".$this->key." JOIN usr ON tuser_id=usr.id "  .$wh." ORDER BY $this->key.".$this->orderBy);
        };
        $this->farr['array'] = function () { return $this->farr['all']()->fetch_all(MYSQLI_ASSOC); };
    }
}


//VIRTUAL
define("VIRT_EXEC","https://dev.aquete.com/virt?__k=".AQU_API_KEY);
function dmp($d,$tag="DMP")  {
    //echo "<br>".$tag.": ".var_export($d,true)."<br><br>";
}

class vsql {
    var $data = [];
    var $all = [];
    var $cursor = 0;
    var $pre = "prp_";

    function fetch_all() {
        return $this->all;
    }

    function fetch_array() {
        if($ret = isset($this->data[$this->cursor])?$this->data[$this->cursor++]:null) {
            foreach($ret as $k=>$v) {
                $ret[substr($k,strlen($this->pre))] = $v;
            }
        }
        return $ret;

    }

    function reset() {
        $this->cursor = 0;
    }

    function exec($pre,$sq,$typ=null,$prm=null) {
        dmp([$sq,$typ,$prm],"REQ");
        $t = base64_encode(json_encode($typ));
        $p = base64_encode(json_encode($prm));
        $r = base64_encode($pre);
        $resp = file_get_contents(VIRT_EXEC."&__q=".urlencode($sq)."&__p=$p&__t=$t&__r=$r");
        dmp($resp,"RSP");

        $this->data = json_decode($resp,true);
        $this->all = [];
        if(is_array($this->data)) foreach($this->data as $r) {
            $ar = [];
            foreach($r as $k=>$v) {
                $ar []= $v;
            }
            $this->all []= $ar;
        }
        $this->cursor = 0;
    }
}

class virtEnt extends ent {
    var $args;
    var $rcls;

    var $farr = [];
    var $aarr = [];

    var $orderBy = "id DESC";
    var $namedBy = "name";

    function delete($id) {
        return $this->ft("DELETE FROM ".$this->key." WHERE id='$id'");
    }


    function ft($sq,$typ=null,$prm=null) {
        $ret = new vsql;
        $ret->exec($this->pre,$sq,$typ,$prm);
        return $ret;
    }
    public function __construct($key, $group) {
        parent::__construct($key, $group);

        $this->farr['raw'] = function ($sql) {
            return $this->ft($sql);
        };

        $this->farr['all'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            return $this->ft("SELECT * FROM ".$this->key.$wh." ORDER BY ".$this->orderBy);
        };

        $this->farr['array'] = function () {
            $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
            $base = $this->ft("SELECT * FROM ".$this->key.$wh." ORDER BY ".$this->orderBy)->fetch_all(MYSQLI_ASSOC);
            foreach($base as $k=>&$v) {
                $v = str_replace("<","[[",$v);
                $v = str_replace(">","]]",$v);
            }
            return $base;
        };

        $this->farr['id'] = function ($id) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE $this->idF=?","s",[$id])->fetch_array();
        };

        $this->farr['by'] = function ($name,$value) {
            return $this->ft("SELECT * FROM ".$this->key." WHERE $name=?","s",[$value])->fetch_array();
        };

        $this->farr['byci'] = function ($name,$value) {
            $value = str_replace(["*","?","%"], "", $value);
            return $this->ft("SELECT * FROM ".$this->key." WHERE $name LIKE ?","s",[$value])->fetch_array();
        };

        $this->farr['options'] = function () {
            $arr = $this->fetch("array");
            $ret = [];
            foreach($arr as $r) {
                $ret []= $r[0];
            }
            return $ret;
        };

        $this->aarr['assert'] = function ($arr=null) {
            if(!$arr) {
                $arr = app::post("?");
                $arr["id"] = app::request("_id");
            }
            return $this->ft("!ASSERT!$this->rcls",null,$arr);
        };
    }

    function fetch($key,...$args) {
        return $this->farr[$key](...$args);
    }

    function action($key,...$args) {
        return $this->aarr[$key](...$args);
    }

    function count() {
        $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
        $res = $this->ft("SELECT COUNT(*) FROM ".$this->key.$wh)->fetch_all();
        return is_array($res)?$res[0][0]:0;
    }

    function sum($k) {
        $wh = isset($this->args["where"])?" WHERE {$this->args['where']} ":"";
        return $this->ft("SELECT SUM($k) FROM ".$this->key.$wh)->fetch_all()[0][0];
    }

    function cell($key,$a) {
        switch($key) {
            case "created":
                return date("m/d/Y",$a[$key]);
            default:
                return parent::cell($key, $a);
        }
    }

    function meta($a,$key) {
        switch($key) {
            case "link":
                return VDIR.substr(app::currentUrl(),1)."?_id=$a[id]";
            default:
                return @$a[$key];
        }
    }
}

class pricePoint extends virtEnt {
    function __construct() {
        parent::__construct("price_point","billing");
        $this->rcls = "pricePoint";
        $this->idF = "prp_id";
        $this->orderBy = "prp_id DESC";
        $this->namedBy = "prp_name";
        $this->pre = "prp_";
        $this->cols = new labelledSet(["code","name","description","hint","amount","duration","duration_unit","occurences","trial_amount","trial_occurences","merchant_id"]);
        
        $this->cols->not['listable'] = ['merchant_id',"code"];

        $this->farr['options'] = function () {
            $arr = $this->fetch("array");
            $ret = [];
            foreach($arr as $r) {
                $ret []= [$r[1],$r[2]];
            }
            return $ret;
        };
    }
}

class payout extends virtEnt {
    function __construct() {
        parent::__construct("payout","billing");
        $this->rcls = "payout";
        $this->idF = "pay_id";
        $this->orderBy = "pay_id DESC";
        $this->namedBy = "pay_reference";
        $this->pre = "pay_";
        $this->cols = new labelledSet(["merchant_id","deposit_date","bank_name","amount","reference","notes"]);
        $this->cols->not['listable'] = ['merchant_id'];
    }
}

class merchant extends virtEnt {
    function __construct() {
        parent::__construct("merchant","billing");
        $this->rcls = "merchant";
        $this->idF = "mer_id";
        $this->orderBy = "mer_id DESC";
        $this->namedBy = "mer_name";
        $this->pre = "mer_";
        $this->cols = new labelledSet(["name","transaction_rate","website","embed_token","api_key","webhook_url","direct_login_email","direct_login_password","merchant_status","company_ein","contact_name","contact_phone","contact_email","payment_method","address_line1","address_line2","address_region","address_zip","address_country"]);
        $this->cols->not['listable'] = ['merchant_id'];
    }
}
