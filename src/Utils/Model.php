<?php namespace LasseRafn\Economic\Utils;

class Model
{
	protected $entity;
	protected $primaryKey;
	protected $modelClass = self::class;
	protected $fillable   = [  ];

	/**
	 * @var Request
	 */
	protected $request;

	function __construct( Request $request, $data = [] )
	{
		$this->request = $request;

		foreach ( $this->fillable as $fillable )
		{
			if ( is_array($data) && isset( $data[ $fillable ] ) )
			{
				if(!method_exists($this, 'set' . ucfirst(camel_case($fillable)) . 'Attribute' ))
				{
					$this->setAttribute($fillable, $data[$fillable]);
				}
				else
				{
					$this->setAttribute($fillable, $this->{'set' . ucfirst(camel_case($fillable)) . 'Attribute'}($data[$fillable]));
				}
			}
			elseif(is_object($data) && isset( $data->{$fillable} ))
			{
				if(!method_exists($this, 'set' . ucfirst(camel_case($fillable)) . 'Attribute' ))
				{
					$this->setAttribute($fillable, $data->{$fillable});
				}
				else
				{
					$this->setAttribute($fillable, $this->{'set' . ucfirst(camel_case($fillable)) . 'Attribute'}($data->{$fillable}));
				}
			}
		}
	}

	function __toString()
	{
		return json_encode($this->toArray());
	}

	function toArray()
	{
		$data = [];

		foreach($this->fillable as $fillable)
		{
			if( isset($this->{$fillable}))
			{
				$data[$fillable] = $this->{$fillable};
			}
		}

		return $data;
	}

	protected function setAttribute( $attribute, $value )
	{
		$this->{$attribute} = $value;
	}

	public function delete()
	{
		return $this->request->curl->delete("/{$this->entity}/{$this->{$this->primaryKey}}");
	}

	public function update($data = [])
	{
		$response = $this->request->curl->put("/{$this->entity}/{$this->{$this->primaryKey}}", [
			'json' => $data
		]);

		$responseData     = json_decode( $response->getBody()->getContents() );

		return new $this->modelClass($this->request, $responseData);
	}
}