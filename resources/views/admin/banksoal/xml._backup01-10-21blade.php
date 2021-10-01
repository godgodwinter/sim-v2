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
                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_start_cdata($xw);
                                    xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">Ini pertanyaan pada soal pertama?&nbsp;<img src=\"@@PLUGINFILE@@/1a1d6752c8a4edbd7939101cd64e57d7.jpg\" alt=\"gambar1\" width=\"467\" height=\"660\" class=\"img-fluid atto_image_button_text-bottom\"></p>");
                                    xmlwriter_end_cdata($xw);
                                xmlwriter_end_element($xw); // text


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
                                xmlwriter_text($xw, '1a1d6752c8a4edbd7939101cd64e57d7.jpg');
                                xmlwriter_end_attribute($xw);

                                    xmlwriter_text($xw, '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');
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

                        xmlwriter_start_element($xw, 'single');
                                xmlwriter_text($xw, 'true');
                        xmlwriter_end_element($xw); // single

                        xmlwriter_start_element($xw, 'shuffleanswers');
                                xmlwriter_text($xw, 'true');
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

                            // Jawaban
                        xmlwriter_start_element($xw, 'answer');

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'format');
                                xmlwriter_text($xw, 'html');
                                xmlwriter_end_attribute($xw);

                                // Attribute 'type' for element 'tag1'
                                xmlwriter_start_attribute($xw, 'fraction');
                                xmlwriter_text($xw, '100');
                                xmlwriter_end_attribute($xw);

                                xmlwriter_start_element($xw, 'text');
                                    xmlwriter_start_cdata($xw);
                                    xmlwriter_text($xw, "<p dir=\"ltr\" style=\"text-align:left;\">jawaban pertama</p>");
                                    xmlwriter_end_cdata($xw);
                                xmlwriter_end_element($xw); // text

                                xmlwriter_start_element($xw, 'feedback');
                                    // Attribute 'type' for element 'tag1'
                                    xmlwriter_start_attribute($xw, 'format');
                                    xmlwriter_text($xw, 'html');
                                    xmlwriter_end_attribute($xw);
                                xmlwriter_end_element($xw); // feedback


                        xmlwriter_end_element($xw); // answer

                            // Jawaban
                            xmlwriter_start_element($xw, 'answer');

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'format');
                                        xmlwriter_text($xw, 'html');
                                        xmlwriter_end_attribute($xw);

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'fraction');
                                        xmlwriter_text($xw, '0');
                                        xmlwriter_end_attribute($xw);

                                        xmlwriter_start_element($xw, 'text');
                                            xmlwriter_start_cdata($xw);
                                            xmlwriter_text($xw, '<p dir="ltr" style="text-align:left;">jawaban kedua</p>');
                                            xmlwriter_end_cdata($xw);
                                        xmlwriter_end_element($xw); // text

                                        xmlwriter_start_element($xw, 'feedback');
                                            // Attribute 'type' for element 'tag1'
                                            xmlwriter_start_attribute($xw, 'format');
                                            xmlwriter_text($xw, 'html');
                                            xmlwriter_end_attribute($xw);
                                        xmlwriter_end_element($xw); // feedback


                            xmlwriter_end_element($xw); // answer


                            // Jawaban
                            xmlwriter_start_element($xw, 'answer');

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'format');
                                        xmlwriter_text($xw, 'html');
                                        xmlwriter_end_attribute($xw);

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'fraction');
                                        xmlwriter_text($xw, '0');
                                        xmlwriter_end_attribute($xw);

                                        xmlwriter_start_element($xw, 'text');
                                            xmlwriter_start_cdata($xw);
                                            xmlwriter_text($xw, '<p dir="ltr" style="text-align:left;">jawaban ketiga</p>');
                                            xmlwriter_end_cdata($xw);
                                        xmlwriter_end_element($xw); // text

                                        xmlwriter_start_element($xw, 'feedback');
                                            // Attribute 'type' for element 'tag1'
                                            xmlwriter_start_attribute($xw, 'format');
                                            xmlwriter_text($xw, 'html');
                                            xmlwriter_end_attribute($xw);
                                        xmlwriter_end_element($xw); // feedback


                            xmlwriter_end_element($xw); // answer


                            // Jawaban
                            xmlwriter_start_element($xw, 'answer');

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'format');
                                        xmlwriter_text($xw, 'html');
                                        xmlwriter_end_attribute($xw);

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'fraction');
                                        xmlwriter_text($xw, '0');
                                        xmlwriter_end_attribute($xw);

                                        xmlwriter_start_element($xw, 'text');
                                            xmlwriter_start_cdata($xw);
                                            xmlwriter_text($xw, '<p dir="ltr" style="text-align:left;">jawaban keempat</p>');
                                            xmlwriter_end_cdata($xw);
                                        xmlwriter_end_element($xw); // text

                                        xmlwriter_start_element($xw, 'feedback');
                                            // Attribute 'type' for element 'tag1'
                                            xmlwriter_start_attribute($xw, 'format');
                                            xmlwriter_text($xw, 'html');
                                            xmlwriter_end_attribute($xw);
                                        xmlwriter_end_element($xw); // feedback


                            xmlwriter_end_element($xw); // answer


                            // Jawaban
                            xmlwriter_start_element($xw, 'answer');

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'format');
                                        xmlwriter_text($xw, 'html');
                                        xmlwriter_end_attribute($xw);

                                        // Attribute 'type' for element 'tag1'
                                        xmlwriter_start_attribute($xw, 'fraction');
                                        xmlwriter_text($xw, '0');
                                        xmlwriter_end_attribute($xw);

                                        xmlwriter_start_element($xw, 'text');
                                            xmlwriter_start_cdata($xw);
                                            xmlwriter_text($xw, '<p dir="ltr" style="text-align:left;">jawaban kelima</p>');
                                            xmlwriter_end_cdata($xw);
                                        xmlwriter_end_element($xw); // text

                                        xmlwriter_start_element($xw, 'feedback');
                                            // Attribute 'type' for element 'tag1'
                                            xmlwriter_start_attribute($xw, 'format');
                                            xmlwriter_text($xw, 'html');
                                            xmlwriter_end_attribute($xw);
                                        xmlwriter_end_element($xw); // feedback


                            xmlwriter_end_element($xw); // answer


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
