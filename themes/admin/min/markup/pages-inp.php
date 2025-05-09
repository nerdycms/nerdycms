<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>

    <title><?=$this->pageTitle()?></title>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/head-style.php'; ?>
    <?=app::asset("themes/admin/min/assets/libs/ace-editor/ace.js")?>		    
    <?=app::asset("themes/admin/min/assets/libs/ace-editor/ext-language_tools.js")?>		
    <?=app::asset("themes/admin/min/assets/libs/choices.js/public/assets/styles/choices.min.css")?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.6.1/beautify.min.js" integrity="sha512-hgViiTix0up961nsHUefwuv2hwJVBN5Sp+0SosVC617MWN2V8Ahoxei2nr4Lts8VAMJapwVcxiyjXDekF/aB6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.6.1/beautify-html.js" integrity="sha512-xGFyQp2AHgj+oVez8wX0CsHTjmzwfKsIN+v3XlwN0eOopZhKIP0wlYbCjyXZzMpTIy81Dd5cZtSeyqwgtAD6wQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
        <script>
            var __sysUplPre = '<?=$this->pdata['upl_pre']?>';
        </script>
</head>

<?php include 'includes/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'includes/menu.php';
    
    $ronly = in_array($this->hook,["/admin/categories","/admin/tags"]);
    $form = $this->form(app::adminRole()); 
    ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <div>
                            <h4 class="d-inline-block mb-sm-0 font-size-18"><?=$this->title($form)?></h4>
                            
                            <?php                 
                                $values = $this->ent?@$this->ent->fetch("id",app::request("_id")):null;
                                if($values) {
                                    echo "&nbsp;&nbsp;<button class='btn btn-sm btn-danger d-inline-block' onclick='del()'>Delete</button>";
                                }
                            ?>
                            </div>
                            
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?=$this->group()?></a></li>
                                    <li class="breadcrumb-item active"><?=$this->title($form)?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->                
                <form id="mf" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="_submit_type" name="_submit_type" value="submit">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">                                                                
                                <div class="float-en2d">
                                    
                                    <?php                
                                    foreach($form->groups as $grp) {    
                                        if($grp->style!="header") continue;
                                        include 'includes/inp-group.php';
                                    } ?>
                                    
                                </div>
                                <h4 class="card-title"><?=$this->label($form->title)?></h4>
                                <p class="card-title-desc"><?=$this->label($form->help)?></p>
                            </div>
                            
                                <div class="card-body p-4"><div class="row">
                <?php   
               
                foreach($form->groups as $grp) {    
                    if($grp->style=="header") continue;
                    include 'includes/inp-group.php';
                } ?>                        
                                
                                </div>
                                <?php if(!$ronly) { ?>
                                <div class="mt-4">
                                    <button onclick="cusSubmit('#mf')" type="button" class="btn btn-primary w-md"><?=$this->label("submit")?></button>
                                    <?php if($canl=$this->label("cancel")) { ?>
                                    <button onclick="cusCancel('#mf')" type="button" class="btn btn-secondary w-md"><?=$canl?></button>
                                    <?php } ?>
                                </div>                                 
                                <?php } ?>    
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->                
                </form>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?php include 'includes/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pleaase confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Delete this item?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="doDel()" type="button" class="btn btn-danger">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Right Sidebar -->
<?php include 'includes/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php include 'includes/vendor-scripts.php'; ?>
<!-- ckeditor -->

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/super-build/ckeditor.js"></script>

<script>
        function del() {
            $('#delModal').modal('show');
        }
        
        function doDel() {
            window.location.href = window.location.href + "&remove=1";
        }
        var allEditors = {};
        var doEditors = async () => {
            var genericExamples = document.querySelectorAll('.edit');
            for (i = 0; i < genericExamples.length; ++i) {
              var element = genericExamples[i];	  
                allEditors[element.id] = await CKEDITOR.ClassicEditor.create($(element).find('.edit-inner')[0], { 
                    // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                    toolbar: {
                        items: [
                            'exportPDF','exportWord', '|',
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            '-',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'alignment', '|',
                            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                            'textPartLanguage', '|',
                            'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    // Changing the language of the interface requires loading the language file using the <script> tag.
                    // language: 'es',
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                    placeholder: 'Enter text...',
                    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                    fontFamily: {
                        options: [
                            'default',
                            'Arial, Helvetica, sans-serif',
                            'Courier New, Courier, monospace',
                            'Georgia, serif',
                            'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif',
                            'Times New Roman, Times, serif',
                            'Trebuchet MS, Helvetica, sans-serif',
                            'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                    fontSize: {
                        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                        supportAllValues: true
                    },
                    // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                    htmlSupport: {
                        allow: [
                            {
                                name: /.*/,
                                attributes: true,
                                classes: true,
                                styles: true
                            }
                        ]
                    },
                    // Be careful with enabling previews
                    // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                    htmlEmbed: {
                        showPreviews: true
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                    mention: {
                        feeds: [
                            {
                                marker: '@',
                                feed: [
                                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                    '@sugar', '@sweet', '@topping', '@wafer'
                                ],
                                minimumCharacters: 1
                            }
                        ]
                    },
                    // The "super-build" contains more premium features that require additional configuration, disable them below.
                    // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                    removePlugins: [
                        // These two are commercial, but you can try them out without registering to a trial.
                        // 'ExportPdf',
                        // 'ExportWord',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                        // Storing images as Base64 is usually a very bad idea.
                        // Replace it on production website with other solutions:
                        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                        // 'Base64UploadAdapter',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                        // from a local file system (file://) - load this site via HTTP server if you enable MathType
                        'MathType'
                    ]
                });
          }  
        }
        </script>


<!-- choices js -->
<?=app::asset("themes/admin/min/assets/libs/choices.js/public/assets/scripts/choices.min.js")?>

<script>    
    var choices = {};
    
    function cusCancel(sel) {
        $(sel).find('#_submit_type').val("cancel");
        return cusSubmit(sel);
    }
    
    function cusSubmit(sel) {
        editSync();
        $('.input-multiple').each(function (i,o) {           
           var val = "";
           var vals = choices[$(o).attr('id')].getValue();             
           for(var i=0;i<vals.length;i++) {
               val += "," + vals[i].value;
           }
           val = val.substr(1);
           $(o).val(val);       
        });
        return $(sel).submit();
    }
    const choicesIssue39Fix = (choicesElement) => {
    choicesElement.input.element.addEventListener('keydown', (keypressEvent) => {
        if (keypressEvent.keyCode === 13 && keypressEvent.target.value) {
            let keywordHits = 0;
            [...choicesElement.choiceList.element.children].forEach((element) => {
                if (element.innerText.includes(keypressEvent.target.value)) {
                    keywordHits += 1;
                }
            });
            if (!keywordHits) {
                keypressEvent.stopPropagation();
                choicesElement.setChoices([
                    {
                        value: keypressEvent.target.value,
                        label: keypressEvent.target.value,
                        selected: true
                    }
                ], 'value', 'label', false);
                const linterEvent = keypressEvent;
                linterEvent.target.value = '';
            }
        }
    });
};

var allAces = {}
var doAce = ()=>{   
    ace.require("ace/ext/language_tools");
    var $edits = $('.ace-editor');
    $edits.each((i,o)=>{
        var $o = $(o);
        var aid = $(o).attr("id");
        var editor = ace.edit($o.find('pre').attr('id'));
        allAces[aid] = editor;
        editor.session.setMode("ace/mode/html");
        editor.setTheme("ace/theme/tomorrow");
        // enable autocompletion and snippets
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: true
        });
    });    
};

var beautOpts = {
      'indent_inner_html': false,
      'indent_size': 2,
      'indent_char': ' ',
      'wrap_line_length': 78,
      'brace_style': 'expand',
      'preserve_newlines': true,
      'max_preserve_newlines': 5,
      'indent_handlebars': false,
      'extra_liners': ['/html']
    };

var editSync = (eid) => {
    var $all;
    if(eid==undefined) $all = $('.edit:visible,.ace-editor:visible');
    else { 
        $all = $('#'+eid);
        if($all.first().is(":visible")) return;
    }

    $all.each((i,o)=> {
        var $e = $(o);
        var $p = $e.parents().first();
        var $c = $p.find('.edit');
        var $a = $p.find('.ace-editor');

        var val;
        if($c.is(':visible')) {
            val = allEditors[$c.attr('id')].getData();
            if(val.indexOf('<p>')===0) val=val.substr(3,val.length - 7);
            $p.find('.edclone').val(val);
            allAces[$a.attr("id")].setValue(html_beautify(val,beautOpts));
        } else {
            val = allAces[$a.attr("id")].getValue();
            $p.find('.edclone').val(val);
            allEditors[$c.attr('id')].setData(val);
        }       
    });
};

document.addEventListener('DOMContentLoaded', function () {
        doAce();doEditors();
    
	var genericExamples = document.querySelectorAll('[multiple]');
	for (i = 0; i < genericExamples.length; ++i) {
	  var element = genericExamples[i];
          
	  var che = new Choices(element,
	  {
		delimiter: ',',
		editItems: true,
                addItems: true,
		maxItemCount: 50,
		removeItemButton: true
	  }
	);
        choicesIssue39Fix(che);
        choices[element.id.substr(1)] = che;      
          
      }  
});



</script>    

<script src="assets/js/app.js"></script>

</body>

</html>