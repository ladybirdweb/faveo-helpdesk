<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\Common\Template;
use App\Http\Requests\helpdesk\TemplateRequest;
use App\Http\Requests\helpdesk\TemplateUdate;
use App\Model\Common\TemplateType;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public $template;
    public $type;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');

        $template = new Template();
        $this->template = $template;

        $type = new TemplateType();
        $this->type = $type;
    }

    public function index()
    {
        try {
            return view('themes.default1.common.template.inbox');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function GetTemplates()
    {
        return \Datatable::collection($this->template->select('id', 'name', 'type')->get())
                        
                        ->showColumns('name')
                        ->addColumn('type', function ($model) {
                            return $this->type->where('id', $model->type)->first()->name;
                        })
                        ->addColumn('action', function ($model) {
                            return '<a href='.url('templates/'.$model->id.'/edit')." class='btn btn-sm btn-primary'>Edit</a>";
                        })
                        ->searchColumns('name')
                        ->orderColumns('name')
                        ->make();
    }

    public function create()
    {
        try {
//            $controller = new ProductController();
//            $url = $controller->GetMyUrl();
            $i = $this->template->orderBy('created_at', 'desc')->first()->id + 1;
//            $cartUrl = $url.'/'.$i;
            $type = $this->type->lists('name', 'id');

            return view('themes.default1.common.template.create', compact('type'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            //dd($request);
            $this->template->fill($request->input())->save();

            return redirect('templates')->with('success', 'Template saved successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        try {
//            $controller = new ProductController();
//            $url = $controller->GetMyUrl();

            $i = $this->template->orderBy('created_at', 'desc')->first()->id + 1;
//            $cartUrl = $url.'/'.$i;
            //dd($cartUrl);
            $template = $this->template->where('id', $id)->first();
            $type = $this->type->lists('name', 'id');

            return view('themes.default1.common.template.edit', compact('type', 'template'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function update($id, TemplateUdate $request)
    {
        try {
            //dd($request);
            $template = $this->template->where('id', $id)->first();
            $template->fill($request->input())->save();

            return redirect('templates')->with('success', 'Template updated successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('select');
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $template = $this->template->where('id', $id)->first();
                    if ($template) {
                        $template->delete();
                    } else {
                        echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.no-record').'
                </div>';
//echo \Lang::get('message.no-record') . '  [id=>' . $id . ']';
                    }
                }
                echo "<div class='alert alert-success alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.success').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.deleted-successfully').'
                </div>';
            } else {
                echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.select-a-row').'
                </div>';
            }
        } catch (\Exception $e) {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.$e->getMessage().'
                </div>';
        }
    }

    public function Mailing($from, $to, $data, $subject, $replace = [], $fromname = '', $toname = '', $cc = [], $attach = [])
    {
        try {
            if (!array_key_exists('title', $replace)) {
                $replace['title'] = '';
            }
            if (!array_key_exists('currency', $replace)) {
                $replace['currency'] = '';
            }
            if (!array_key_exists('price', $replace)) {
                $replace['price'] = '';
            }
            if (!array_key_exists('subscription', $replace)) {
                $replace['subscription'] = '';
            }
            if (!array_key_exists('name', $replace)) {
                $replace['name'] = '';
            }
            if (!array_key_exists('url', $replace)) {
                $replace['url'] = '';
            }
            if (!array_key_exists('password', $replace)) {
                $replace['password'] = '';
            }
            if (!array_key_exists('address', $replace)) {
                $replace['address'] = '';
            }
            if (!array_key_exists('username', $replace)) {
                $replace['username'] = '';
            }
            if (!array_key_exists('email', $replace)) {
                $replace['email'] = '';
            }
            if (!array_key_exists('product', $replace)) {
                $replace['product'] = '';
            }
            $array1 = ['{{title}}', '{{currency}}', '{{price}}', '{{subscription}}', '{{name}}', '{{url}}', '{{password}}', '{{address}}', '{{username}}', '{{email}}', '{{product}}'];
            $array2 = [$replace['title'], $replace['currency'], $replace['price'], $replace['subscription'], $replace['name'], $replace['url'], $replace['password'], $replace['address'], $replace['username'], $replace['email'], $replace['product']];

            $data = str_replace($array1, $array2, $data);
            $settings = \App\Model\Common\Setting::find(1);
            $fromname = $settings->company;
            \Mail::send('emails.mail', ['data' => $data], function ($m) use ($from, $to, $subject, $fromname, $toname, $cc, $attach) {

                $m->from($from, $fromname);

                $m->to($to, $toname)->subject($subject);

                /* if cc is need  */
                if (!empty($cc)) {
                    foreach ($cc as $address) {
                        $m->cc($address['address'], $address['name']);
                    }
                }

                /*  if attachment is need */
                if (!empty($attach)) {
                    foreach ($attach as $file) {
                        $m->attach($file['path'], $options = []);
                    }
                }
            });
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception('mailing problem');
        }
    }

    public function mailtest($id)
    {
        $from = 'vijaysebastian111@gmail.com';
        $to = 'vijay.sebastian@ladybirdweb.com';
        $subject = 'Tsting the mailer';
        $template = Template::where('id', $id)->whereBetween('type', [1, 8])->first();
        if ($template) {
            $data = $template->data;
        } else {
            return 'Select valid template';
        }
        $cc = [
            0 => [
                'name'    => 'vijay',
                'address' => 'vijaysebastian111@gmail.com',
            ],
            1 => [
                'name'    => 'vijay sebastian',
                'address' => 'vijaysebastian23@gmail.com',
            ],
        ];
        $attachments = [
            0 => [
                'path' => public_path('dist/img/avatar.png'),
            ],
        ];
        $replace = [
            'name'     => 'vijay sebastian',
            'usernmae' => 'vijay',
            'password' => 'jfdvhd',
            'address'  => 'dshbcvhjdsbvchdff',
        ];
        $this->Mailing($from, $to, $data, $subject, $replace, 'from', 'to', $cc, $attachments);
    }

    public function show($id)
    {

        //dd($currency);
        try {
            if ($this->template->where('type', 3)->where('id', $id)->first()) {
                $data = $this->template->where('type', 3)->where('id', $id)->first()->data;
                //dd($data);

                $products = $this->product->where('id', '!=', 1)->take(4)->get();

                //dd($products);
                if (count($products) > 0) {
                    $template = '';
                    foreach ($products as $product) {
                        //dd($this->checkPriceWithTaxClass($product->id, $currency));
                        $url = $product->shoping_cart_link;
                        $title = $product->name;
                        if ($product->description) {
                            $description = str_replace('</ul>', '', str_replace('<ul>', '', $product->description));
                        } else {
                            $description = '';
                        }
                        $currency = \Session::get('currency');
                        if ($this->price->where('product_id', $product->id)->where('currency', $currency)->first()) {

//                            $rule = $this->tax_rule->findOrFail(1);
//                            if ($rule->shop_inclusive == 0 && $rule->tax_enable == 1 && $rule->inclusive == 0) {
//                                $price = $this->checkPriceWithTaxClass($product->id, $currency);
//                            } else {
//                                $price = $this->withoutTaxRelation($product->id, $currency);
//                            }

                            $product_currency = $this->price->where('product_id', $product->id)->where('currency', $currency)->first();
                            $code = $product_currency->currency;
                            $currency = $this->currency->where('code', $code)->first();

                            if ($currency->symbol) {
                                $currency = $currency->symbol;
                            } else {
                                $currency = $currency->code;
                            }
                            $price = \App\Http\Controllers\Front\CartController::calculateTax($product->id, $product_currency->currency, 1, 0, 1);

                            $subscription = $this->plan->where('id', $product_currency->subscription)->first()->name;
                        } else {
                            return redirect('/')->with('fails', \Lang::get('message.no-such-currency-in-system'));
                        }

                        $array1 = ['{{title}}', '{{currency}}', '{{price}}', '{{subscription}}', '<li>{{feature}}</li>', '{{url}}'];
                        $array2 = [$title, $currency, $price, $subscription, $description, $url];
                        $template .= str_replace($array1, $array2, $data);
                    }

                    //dd($template);
                    return view('themes.default1.common.template.shoppingcart', compact('template'));
                } else {
                    $template = '<p>No Products</p>';

                    return view('themes.default1.common.template.shoppingcart', compact('template'));
                }
            } else {
                return redirect('/')->with('fails', 'no such record');
            }
        } catch (\Exception $e) {
            dd($e);

            return redirect('/')->with('fails', $e->getMessage());
        }
    }

    public function popup($title, $body, $width = '897', $name = '', $modelid = '', $class = 'null', $trigger = false)
    {
        try {
            if ($modelid == '') {
                $modelid = $title;
            }
            if ($trigger == true) {
                $trigger = "<a href=# class=$class  data-toggle='modal' data-target=#edit".$modelid.'>'.$name.'</a>';
            } else {
                $trigger = '';
            }

            return $trigger."
                        <div class='modal fade' id=edit".$modelid.">
                            <div class='modal-dialog' style='width: ".$width."px;'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        <h4 class='modal-title'>".$title."</h4>
                                    </div>
                                    <div class='modal-body'>
                                    ".$body."
                                    </div>
                                    <div class='modal-footer'>
                                        <button type=button id=close class='btn btn-default pull-left' data-dismiss=modal>Close</button>
                                        <input type=submit class='btn btn-primary' value=".\Lang::get('message.save').'>
                                    </div>
                                    '.\Form::close().'
                                </div>
                            </div>
                        </div>';
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function checkPriceWithTaxClass($productid, $currency)
    {
        try {
            $product = $this->product->findOrFail($productid);
            //dd($product);
            if ($product->tax_apply == 1) {
                $price = $this->checkTax($product->id, $currency);
            } else {
                $price = $product->price()->where('currency', $currency)->first()->sales_price;
                if (!$price) {
                    $price = $product->price()->where('currency', $currency)->first()->price;
                }
            }
            //dd($price);
            return $price;
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    public function checkTax($productid, $currency, $cart = 0, $cart1 = 0, $shop = 0)
    {
        try {
            $product = $this->product->findOrFail($productid);
            $price = $product->price()->where('currency', $currency)->first()->sales_price;
            if (!$price) {
                $price = $product->price()->where('currency', $currency)->first()->price;
            }
            $tax_relation = $this->tax_relation->where('product_id', $productid)->first();
            if (!$tax_relation) {
                return $this->withoutTaxRelation($productid, $currency);
            }
            $taxes = $this->tax->where('tax_classes_id', $tax_relation->tax_class_id)->where('active', 1)->orderBy('created_at', 'asc')->get();
            if (count($taxes) == 0) {
                throw new \Exception('No taxes is avalable');
            }
            if ($cart == 1) {
                $tax_amount = $this->taxProcess($taxes, $price, $cart1, $shop);
            } else {
                $rate = '';
                foreach ($taxes as $tax) {
                    if ($tax->compound != 1) {
                        $rate += $tax->rate;
                    } else {
                        $rate = $tax->rate;
                        $price = $this->calculateTotal($rate, $price);
                    }
                    $tax_amount = $this->calculateTotal($rate, $price);
                }
            }

            return $tax_amount;
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    public function taxProcess($taxes, $price, $cart, $shop)
    {
        try {
            $rate = '';
            foreach ($taxes as $tax) {
                if ($tax->compound != 1) {
                    $rate += $tax->rate;
                } else {
                    $rate = $tax->rate;
                }

                $tax_amount = $this->ifStatement($rate, $price, $cart, $shop, $tax->country, $tax->state);
            }
            //dd($tax_amount);
            return $tax_amount;
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    public function ifStatement($rate, $price, $cart1, $shop1, $country = '', $state = '')
    {
        try {
            $tax_rule = $this->tax_rule->find(1);
            $product = $tax_rule->inclusive;
            $shop = $tax_rule->shop_inclusive;
            $cart = $tax_rule->cart_inclusive;
            $result = $price;

            $location = \GeoIP::getLocation();
            $counrty_iso = $location['isoCode'];
            $state_code = $location['isoCode'].'-'.$location['state'];

            $geoip_country = '';
            $geoip_state = '';
            if (\Auth::user()) {
                $geoip_country = \Auth::user()->country;
                $geoip_state = \Auth::user()->state;
            }
            if ($geoip_country == '') {
                $geoip_country = \App\Http\Controllers\Front\CartController::findCountryByGeoip($counrty_iso);
            }
            $geoip_state_array = \App\Http\Controllers\Front\CartController::getStateByCode($state_code);
            if ($geoip_state == '') {
                $geoip_state = $geoip_state_array['id'];
            }

            //dd($geoip_country);
            if ($country == $geoip_country || $state == $geoip_state || ($country == '' && $state == '')) {
                if ($product == 1 && $shop == 1 && $cart == 1) {
                    $result = $this->calculateTotalcart($rate, $price, $cart1 = 0, $shop1 = 0);
                }
                if ($product == 1 && $shop == 0 && $cart == 0) {
                    $result = $this->calculateSub($rate, $price, $cart1 = 1, $shop1 = 1);
                }
                if ($product == 1 && $shop == 1 && $cart == 0) {
                    $result = $this->calculateSub($rate, $price, $cart1, $shop1 = 0);
                }
                if ($product == 1 && $shop == 0 && $cart == 1) {
                    $result = $this->calculateSub($rate, $price, $cart1 = 0, $shop1);
                }
                if ($product == 0 && $shop == 0 && $cart == 0) {
                    $result = $this->calculateTotalcart($rate, $price, $cart1 = 0, $shop1 = 0);
                }
                if ($product == 0 && $shop == 1 && $cart == 1) {
                    $result = $this->calculateTotalcart($rate, $price, $cart1, $shop1);
                }
                if ($product == 0 && $shop == 1 && $cart == 0) {
                    $result = $this->calculateTotalcart($rate, $price, $cart1 = 0, $shop1);
                }
                if ($product == 0 && $shop == 0 && $cart == 1) {
                    $result = $this->calculateTotalcart($rate, $price, $cart1, $shop1 = 0);
                }
            }

            return $result;
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    public function withoutTaxRelation($productid, $currency)
    {
        try {
            $product = $this->product->findOrFail($productid);
            $price = $product->price()->where('currency', $currency)->first()->sales_price;
            if (!$price) {
                $price = $product->price()->where('currency', $currency)->first()->price;
            }
            //dd($price);
            return $price;
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    public function calculateTotal($rate, $price)
    {
        try {
            $tax_amount = $price * ($rate / 100);
            $total = $price + $tax_amount;
            //dd($total);
            return $total;
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function calculateSub($rate, $price, $cart, $shop)
    {
        try {
            if (($cart == 1 && $shop == 1) || ($cart == 1 && $shop == 0) || ($cart == 0 && $shop == 1)) {
                $total = $price / (($rate / 100) + 1);

                return $total;
            }

            return $price;
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function calculateTotalcart($rate, $price, $cart, $shop)
    {
        try {
            if (($cart == 1 && $shop == 1) || ($cart == 1 && $shop == 0) || ($cart == 0 && $shop == 1)) {
                $tax_amount = $price * ($rate / 100);
                $total = $price + $tax_amount;
                //dd($total);
                return $total;
            }

            return $price;
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
