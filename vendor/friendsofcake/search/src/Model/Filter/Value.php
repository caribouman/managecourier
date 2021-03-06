<?php
namespace Search\Model\Filter;

use Cake\Database\Expression\QueryExpression;

class Value extends Base
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'mode' => 'OR'
    ];

    /**
     * Process a value condition ($x == $y).
     *
     * @return void
     */
    public function process()
    {
        if ($this->skip()) {
            return;
        }

        $value = $this->value();
        if ($value === null) {
            return;
        }

        $isMultiValue = is_array($value);
        if ($isMultiValue &&
            empty($value)
        ) {
            return;
        }

        $expressions = [];
        foreach ($this->fields() as $field) {
            $expressions[] = function (QueryExpression $e) use ($field, $value, $isMultiValue) {
                if ($isMultiValue) {
                    return $e->in($field, $value);
                }

                return $e->eq($field, $value);
            };
        }

        if (!empty($expressions)) {
            $this->query()->andWhere([$this->config('mode') => $expressions]);
        }
    }
}
