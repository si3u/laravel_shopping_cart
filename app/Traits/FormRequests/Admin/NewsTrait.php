<?php
namespace App\Traits\FormRequests\Admin;

trait NewsTrait {
    private function GenerateRules() {
        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['topic_'.$this->active_local[$i]->lang] = 'required|string|max:255';
            $this->rules_local['text_'.$this->active_local[$i]->lang] = 'required|string';
            $this->rules_local['meta_title_'.$this->active_local[$i]->lang] = 'nullable|string|max:255';
            $this->rules_local['meta_description_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['meta_keywords_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['tags_'.$this->active_local[$i]->lang] = 'nullable|string';

            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали Наименование ('.$this->active_local[$i]->lang.')';
            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';
            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.max'] = 'Наименование ('.$this->active_local[$i]->lang.') не должно превышать 255 символов';
            $this->messages_local['text_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали  Тект новости ('.$this->active_local[$i]->lang.')';
            $this->messages_local['text_'.$this->active_local[$i]->lang.'.string'] = 'Тект новости ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.string'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.max'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле не должно превышать 255 символов';
            $this->messages_local['meta_description_'.$this->active_local[$i]->lang.'.string'] = 'Meta Description ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_keywords_'.$this->active_local[$i]->lang.'.string'] = 'Meta Keywords ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['tags_'.$this->active_local[$i]->lang.'.string'] = 'Теги ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';

            $i++;
        }
    }
}