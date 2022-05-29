<?php namespace App\Http\Requests;

class BookingSaveRequest extends FormRequest
{
    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            if ($this->canUpdateJob())
            {
                $validator->errors()->add('admincomment', 'Please, add comment!');
            }
        });
    }

    private function canUpdateJob(): bool
    {
        $flagged = $this->request->get('flagged');
        $adminComment = $this->request->get('admincomment');

        if ($flagged == 'true' && !$adminComment)
        {
            return false;
        }

        return true;
    }
}