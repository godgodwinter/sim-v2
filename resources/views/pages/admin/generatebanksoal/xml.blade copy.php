<?php

$xw = xmlwriter_open_memory();
xmlwriter_set_indent($xw, 1);
$res = xmlwriter_set_indent_string($xw, ' ');

xmlwriter_start_document($xw, '1.0', 'UTF-8');

// A first element
    xmlwriter_start_element($xw, 'quiz');
    xmlwriter_write_comment($xw, 'question: 0'); //komentar element pertama

    // Start a child element
            xmlwriter_start_element($xw, 'question');
                    // Attribute 'type' for element 'tag1'
                    xmlwriter_start_attribute($xw, 'type');
                    xmlwriter_text($xw, 'category');
                    xmlwriter_end_attribute($xw);


                            xmlwriter_start_element($xw, 'category');
                                    xmlwriter_start_element($xw, 'text');
                                        xmlwriter_text($xw, '$course$/top/Default for Front page');
                                    xmlwriter_end_element($xw); // text


                            xmlwriter_end_element($xw); // category

                            xmlwriter_start_element($xw, 'info');

                                    // Attribute 'type' for element 'tag1'
                                    xmlwriter_start_attribute($xw, 'format');
                                    xmlwriter_text($xw, 'moodle_auto_format');
                                    xmlwriter_end_attribute($xw);

                                    xmlwriter_start_element($xw, 'text');
                                        xmlwriter_text($xw, "The default category for questions shared in context 'Front page'.");
                                    xmlwriter_end_element($xw); // text


                            xmlwriter_end_element($xw); // info

                            xmlwriter_start_element($xw, 'idnumber');
                            xmlwriter_end_element($xw); // idnumber



            xmlwriter_end_element($xw); // question

// dd($datas);
?>
@foreach ($datas as $data)
<?php
//mulai soal
    xmlwriter_write_comment($xw, 'question:'.$data->id.''); //komentar element pertama

// Start a child element
        xmlwriter_start_element($xw, 'question');
                // Attribute 'type' for element 'tag1'
                xmlwriter_start_attribute($xw, 'type');
                xmlwriter_text($xw, 'multichoice');
                xmlwriter_end_attribute($xw);


                        xmlwriter_start_element($xw, 'name');
                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_text($xw, $data->pertanyaan);
                                xmlwriter_end_element($xw); // text


                        xmlwriter_end_element($xw); // name

                        xmlwriter_start_element($xw, 'questiontext');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);


                                // -<![CDATA[<p dir="ltr" style="text-align:left;">Ini pertanyaan pada soal pertama?&nbsp;<img src="@@PLUGINFILE@@/1a1d6752c8a4edbd7939101cd64e57d7.jpg" alt="gambar1" width="467" height="660" class="img-fluid atto_image_button_text-bottom"></p>]]>
                                if($data->gambar!='' AND $data->gambar!=null){
                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_start_cdata($xw);
                                    xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">".$data->pertanyaan."&nbsp;<br></p><p dir=\"ltr\" style=\"text-align: left;\"><img src=\"@@PLUGINFILE@@/".$data->kodegenerate.".jpg\" alt=\"gambar1\" width=\"467\" height=\"660\" class=\"img-fluid atto_image_button_text-bottom\">

                                        </p>");
                                    xmlwriter_end_cdata($xw);
                                xmlwriter_end_element($xw); // text
                                }else{
                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_start_cdata($xw);
                                    xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">".$data->pertanyaan."&nbsp;
                                        &nbsp;
                                        </p>");
                                    xmlwriter_end_cdata($xw);
                                xmlwriter_end_element($xw); // text

                                }



                                xmlwriter_start_element($xw, 'file');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'encoding');
                                xmlwriter_text($xw, 'base64');
                                xmlwriter_end_attribute($xw);


                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'path');
                                xmlwriter_text($xw, '/');
                                xmlwriter_end_attribute($xw);


                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'name');
                                xmlwriter_text($xw, $data->kodegenerate.'.jpg');
                                xmlwriter_end_attribute($xw);

                                    xmlwriter_text($xw, $data->gambar);
                                xmlwriter_end_element($xw); // file


                        xmlwriter_end_element($xw); // questiontext

                        xmlwriter_start_element($xw, 'generalfeedback');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);

                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_start_cdata($xw);
                                    xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">asd</p>");
                                    xmlwriter_end_cdata($xw);
                                xmlwriter_end_element($xw); // text


                        xmlwriter_end_element($xw); // generalfeedback

                        xmlwriter_start_element($xw, 'defaultgrade');
                                xmlwriter_text($xw, '1.0000000');
                        xmlwriter_end_element($xw); // defaultgrade

                        xmlwriter_start_element($xw, 'penalty');
                                xmlwriter_text($xw, '0.3333333');
                        xmlwriter_end_element($xw); // penalty

                        xmlwriter_start_element($xw, 'hidden');
                                xmlwriter_text($xw, '0');
                        xmlwriter_end_element($xw); // hidden

                        xmlwriter_start_element($xw, 'idnumber');
                        xmlwriter_end_element($xw); // idnumber
                            if($data->kategorisoal_nama!=2){
                                xmlwriter_start_element($xw, 'single');
                                        xmlwriter_text($xw, 'true');
                                xmlwriter_end_element($xw); // single
                            }else{
                                xmlwriter_start_element($xw, 'single');
                                        xmlwriter_text($xw, 'false');
                                xmlwriter_end_element($xw); // single

                            }

                        xmlwriter_start_element($xw, 'shuffleanswers');
                                xmlwriter_text($xw, 'false');
                        xmlwriter_end_element($xw); // shuffleanswers

                        xmlwriter_start_element($xw, 'answernumbering');
                                xmlwriter_text($xw, 'abc');
                        xmlwriter_end_element($xw); // answernumbering

                        xmlwriter_start_element($xw, 'showstandardinstruction');
                                xmlwriter_text($xw, '0');
                        xmlwriter_end_element($xw); // showstandardinstruction

                        xmlwriter_start_element($xw, 'correctfeedback');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);

                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_text($xw, 'Your answer is correct.');
                                xmlwriter_end_element($xw); // text


                        xmlwriter_end_element($xw); // correctfeedback


                        xmlwriter_start_element($xw, 'partiallycorrectfeedback');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);

                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_text($xw, 'Your answer is partially correct.');
                                xmlwriter_end_element($xw); // text


                        xmlwriter_end_element($xw); // partiallycorrectfeedback


                        xmlwriter_start_element($xw, 'incorrectfeedback');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);

                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_text($xw, 'Your answer is incorrect.');
                                xmlwriter_end_element($xw); // text


                        xmlwriter_end_element($xw); // incorrectfeedback


                        xmlwriter_start_element($xw, 'shownumcorrect');
                        xmlwriter_end_element($xw); // shownumcorrect

                        $kodegenerate=$data->kodegenerate;
                        $jmljawaban=DB::table('banksoal_jawaban')->where('kodegenerate',$kodegenerate)->count();
                        $ambilbanksoal_jawaban=DB::table('banksoal_jawaban')->where('kodegenerate',$kodegenerate)->get();
                        if($jmljawaban>0){
                            foreach($ambilbanksoal_jawaban as $ambiljawaban){

                            // Jawaban
                        xmlwriter_start_element($xw, 'answer');

                        // Attribute 'type' for element 'tag1'
                        xmlwriter_start_attribute($xw, 'format');
                        xmlwriter_text($xw, 'html');
                        xmlwriter_end_attribute($xw);

                        // Attribute 'type' for element 'tag1'
                        xmlwriter_start_attribute($xw, 'fraction');
                        xmlwriter_text($xw, $ambiljawaban->nilai);
                        xmlwriter_end_attribute($xw);

                        xmlwriter_start_element($xw, 'text');
                            xmlwriter_start_cdata($xw);
                            xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">".$ambiljawaban->jawaban."</p>");
                            xmlwriter_end_cdata($xw);
                        xmlwriter_end_element($xw); // text

                        xmlwriter_start_element($xw, 'feedback');
                            // Attribute 'type' for element 'tag1'
                            xmlwriter_start_attribute($xw, 'format');
                            xmlwriter_text($xw, 'html');
                            xmlwriter_end_attribute($xw);
                        xmlwriter_end_element($xw); // feedback


                        xmlwriter_end_element($xw); // answer

                            }
                        }



        xmlwriter_end_element($xw); // question
?>
        @endforeach
<?php


    xmlwriter_end_element($xw); // Quiz


// A processing instruction
// xmlwriter_start_pi($xw, 'php');
// xmlwriter_text($xw, '$foo=2;echo $foo;');
// xmlwriter_end_pi($xw);

xmlwriter_end_document($xw);

echo xmlwriter_output_memory($xw);
