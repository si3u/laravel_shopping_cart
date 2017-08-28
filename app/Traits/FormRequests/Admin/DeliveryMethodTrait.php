<?php
namespace App\Traits\FormRequests\Admin;

trait DeliveryMethodTrait {
    private function GenerateRules() {
        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['name_'.$this->active_local[$i]->lang] = 'required|string';

            $this->messages_local['name_'.$this->active_local[$i]->lang.'.required'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть заполнено';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';

            $i++;
        }

        $this->rules_local['payment_methods'] = 'required';
        $this->rules_local['payment_methods.*'] = 'integer|exists:payment_methods,id';

        $this->messages_local['payment_methods.required'] = 'Вы не выбрали Метода оплаты';
        $this->messages_local['payment_methods.*.integer'] = 'Значение Методов оплаты должно быть целочисленным';
        $this->messages_local['payment_methods.*.exists'] = 'Один с Методов оплаты не существует';
    }
}